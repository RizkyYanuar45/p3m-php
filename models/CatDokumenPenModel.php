<?php

/**
 * Category Dokumen Penelitian Model
 * Table: catDokumenPens
 */

require_once __DIR__ . '/../config/database.php';

class CatDokumenPenModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM `catDokumenPens` ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM `catDokumenPens`");
        return (int) $stmt->fetchColumn();
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT * FROM `catDokumenPens` ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get all categories with their documents (JOIN)
     */
    public function findAllWithDokumen(): array
    {
        $stmt = $this->db->query("SELECT c.*, d.id as dok_id, d.file_name, d.file_url FROM `catDokumenPens` c LEFT JOIN `dokumenPens` d ON c.id = d.catdokumenpenId ORDER BY c.id DESC, d.id ASC");
        $rows = $stmt->fetchAll();

        // Group documents under their category
        $categories = [];
        foreach ($rows as $row) {
            $catId = $row['id'];
            if (!isset($categories[$catId])) {
                $categories[$catId] = [
                    'id'        => $row['id'],
                    'name'      => $row['name'],
                    'createdAt' => $row['createdAt'],
                    'updatedAt' => $row['updatedAt'],
                    'dokumen'   => [],
                ];
            }
            if ($row['dok_id']) {
                $categories[$catId]['dokumen'][] = [
                    'id'        => $row['dok_id'],
                    'file_name' => $row['file_name'],
                    'file_url'  => $row['file_url'],
                ];
            }
        }
        return array_values($categories);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `catDokumenPens` WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByIdWithDokumen(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT c.*, d.id as dok_id, d.file_name, d.file_url FROM `catDokumenPens` c LEFT JOIN `dokumenPens` d ON c.id = d.catdokumenpenId WHERE c.id = :id ORDER BY d.id ASC");
        $stmt->execute([':id' => $id]);
        $rows = $stmt->fetchAll();

        if (empty($rows)) return null;

        $category = [
            'id'        => $rows[0]['id'],
            'name'      => $rows[0]['name'],
            'createdAt' => $rows[0]['createdAt'],
            'updatedAt' => $rows[0]['updatedAt'],
            'dokumen'   => [],
        ];
        foreach ($rows as $row) {
            if ($row['dok_id']) {
                $category['dokumen'][] = [
                    'id'        => $row['dok_id'],
                    'file_name' => $row['file_name'],
                    'file_url'  => $row['file_url'],
                ];
            }
        }
        return $category;
    }

    public function create(array $data): ?array
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO `catDokumenPens` (name, createdAt, updatedAt) VALUES (:name, :createdAt, :updatedAt)");
        $stmt->execute([':name' => $data['name'] ?? null, ':createdAt' => $now, ':updatedAt' => $now]);
        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE `catDokumenPens` SET name = :name, updatedAt = :updatedAt WHERE id = :id");
        return $stmt->execute([':name' => $data['name'] ?? null, ':updatedAt' => date('Y-m-d H:i:s'), ':id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `catDokumenPens` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
