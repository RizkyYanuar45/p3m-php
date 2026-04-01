<?php

/**
 * Admin Model
 * Table: Admins
 */

require_once __DIR__ . '/../config/database.php';

class AdminModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT id, username, createdAt, updatedAt FROM `Admins` ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, username, createdAt, updatedAt FROM `Admins` WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT id, username, password, createdAt, updatedAt FROM `Admins` WHERE username = :username LIMIT 1");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("DB Error in findByUsername: " . $e->getMessage());
            return null;
        }
    }

    public function create(string $username, string $hashedPassword): ?array
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO `Admins` (username, password, createdAt, updatedAt) VALUES (:username, :password, :createdAt, :updatedAt)");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':createdAt', $now, PDO::PARAM_STR);
        $stmt->bindValue(':updatedAt', $now, PDO::PARAM_STR);
        $stmt->execute();
        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id, ':updatedAt' => date('Y-m-d H:i:s')];

        if (isset($data['username'])) {
            $fields[] = "username = :username";
            $params[':username'] = $data['username'];
        }
        if (isset($data['password'])) {
            $fields[] = "password = :password";
            $params[':password'] = $data['password'];
        }

        if (empty($fields)) {
            return false;
        }

        $fields[] = "updatedAt = :updatedAt";
        $sql = "UPDATE `Admins` SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $value, $type);
        }
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `Admins` WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
