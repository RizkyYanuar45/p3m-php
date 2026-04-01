<?php

/**
 * File Model
 * Table: files
 */

require_once __DIR__ . '/../config/database.php';

class FileModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM `files` ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `files` WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByType(string $type): array
    {
        $stmt = $this->db->prepare("SELECT * FROM `files` WHERE file_type = :type ORDER BY id DESC");
        $stmt->execute([':type' => $type]);
        return $stmt->fetchAll();
    }

    public function countByType(string $type): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM `files` WHERE file_type = :type");
        $stmt->execute([':type' => $type]);
        return (int) $stmt->fetchColumn();
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM `files`");
        return (int) $stmt->fetchColumn();
    }

    public function findPaginatedByType(string $type, int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT * FROM `files` WHERE file_type = :type ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create(array $data): ?array
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO `files` (file_url, file_name, file_type, file_description, createdAt, updatedAt) VALUES (:file_url, :file_name, :file_type, :file_description, :createdAt, :updatedAt)");
        $stmt->execute([
            ':file_url'         => $data['file_url'] ?? '',
            ':file_name'        => $data['file_name'] ?? '',
            ':file_type'        => $data['file_type'],
            ':file_description' => $data['file_description'] ?? null,
            ':createdAt'        => $now,
            ':updatedAt'        => $now,
        ]);
        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id, ':updatedAt' => date('Y-m-d H:i:s')];

        foreach (['file_url', 'file_name', 'file_type', 'file_description'] as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }

        if (empty($fields)) return false;

        $fields[] = "updatedAt = :updatedAt";
        $sql = "UPDATE `files` SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `files` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
