<?php

/**
 * Profile Model
 * Table: profiles
 */

require_once __DIR__ . '/../config/database.php';

class ProfileModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM `profiles` ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `profiles` WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByType(string $type): array
    {
        $stmt = $this->db->prepare("SELECT * FROM `profiles` WHERE type = :type ORDER BY id DESC");
        $stmt->execute([':type' => $type]);
        return $stmt->fetchAll();
    }

    public function findOneByType(string $type): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `profiles` WHERE type = :type LIMIT 1");
        $stmt->execute([':type' => $type]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): ?array
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO `profiles` (image, alt, type, createdAt, updatedAt) VALUES (:image, :alt, :type, :createdAt, :updatedAt)");
        $stmt->execute([
            ':image'     => $data['image'] ?? null,
            ':alt'       => $data['alt'] ?? '',
            ':type'      => $data['type'],
            ':createdAt' => $now,
            ':updatedAt' => $now,
        ]);
        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id, ':updatedAt' => date('Y-m-d H:i:s')];

        foreach (['image', 'alt', 'type'] as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }

        if (empty($fields)) {
            return false;
        }

        $fields[] = "updatedAt = :updatedAt";
        $sql = "UPDATE `profiles` SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `profiles` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
