<?php

/**
 * Dokumen Profil Model
 * Table: dokumenProfs
 */

require_once __DIR__ . '/../config/database.php';

class DokumenProfModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT d.*, c.name as kategori_name, c.id as kategori_id FROM `dokumenProfs` d LEFT JOIN `catDokumenProfs` c ON d.catdokumenprofId = c.id ORDER BY d.id DESC");
        $rows = $stmt->fetchAll();
        return array_map([$this, 'formatWithKategori'], $rows);
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM `dokumenProfs`");
        return (int) $stmt->fetchColumn();
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT d.*, c.name as kategori_name, c.id as kategori_id FROM `dokumenProfs` d LEFT JOIN `catDokumenProfs` c ON d.catdokumenprofId = c.id ORDER BY d.id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return array_map([$this, 'formatWithKategori'], $rows);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT d.*, c.name as kategori_name, c.id as kategori_id FROM `dokumenProfs` d LEFT JOIN `catDokumenProfs` c ON d.catdokumenprofId = c.id WHERE d.id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ? $this->formatWithKategori($result) : null;
    }

    public function create(array $data): ?array
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO `dokumenProfs` (file_url, file_name, catdokumenprofId, createdAt, updatedAt) VALUES (:file_url, :file_name, :catdokumenprofId, :createdAt, :updatedAt)");
        $stmt->execute([
            ':file_url'           => $data['file_url'] ?? '',
            ':file_name'          => $data['file_name'] ?? '',
            ':catdokumenprofId'   => $data['catdokumenprofId'],
            ':createdAt'          => $now,
            ':updatedAt'          => $now,
        ]);
        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id, ':updatedAt' => date('Y-m-d H:i:s')];
        foreach (['file_url', 'file_name', 'catdokumenprofId'] as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        if (empty($fields)) return false;
        $fields[] = "updatedAt = :updatedAt";
        $sql = "UPDATE `dokumenProfs` SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `dokumenProfs` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function findRawById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `dokumenProfs` WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    private function formatWithKategori(array $row): array
    {
        return [
            'id' => $row['id'],
            'file_url' => $row['file_url'],
            'file_name' => $row['file_name'],
            'catdokumenprofId' => $row['catdokumenprofId'],
            'createdAt' => $row['createdAt'],
            'updatedAt' => $row['updatedAt'],
            'kategori' => ['name' => $row['kategori_name'] ?? null, 'id' => $row['kategori_id'] ?? null],
        ];
    }
}
