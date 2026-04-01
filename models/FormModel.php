<?php

/**
 * Form Model
 * Table: Forms
 */

require_once __DIR__ . '/../config/database.php';

class FormModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM `Forms` ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `Forms` WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): ?array
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO `Forms` (link, name, createdAt, updatedAt) VALUES (:link, :name, :createdAt, :updatedAt)");
        $stmt->execute([
            ':link'      => $data['link'] ?? '',
            ':name'      => $data['name'] ?? '',
            ':createdAt' => $now,
            ':updatedAt' => $now,
        ]);
        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id, ':updatedAt' => date('Y-m-d H:i:s')];

        foreach (['link', 'name'] as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }

        if (empty($fields)) return false;

        $fields[] = "updatedAt = :updatedAt";
        $sql = "UPDATE `Forms` SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `Forms` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
