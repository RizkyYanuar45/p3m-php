<?php

/**
 * Youtube Model
 * Table: Youtubes
 */

require_once __DIR__ . '/../config/database.php';

class YoutubeModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM `Youtubes` ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM `Youtubes`");
        return (int) $stmt->fetchColumn();
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT * FROM `Youtubes` ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `Youtubes` WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): ?array
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO `Youtubes` (title, link, createdAt, updatedAt) VALUES (:title, :link, :createdAt, :updatedAt)");
        $stmt->execute([
            ':title'     => $data['title'] ?? '',
            ':link'      => $data['link'] ?? '',
            ':createdAt' => $now,
            ':updatedAt' => $now,
        ]);
        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id, ':updatedAt' => date('Y-m-d H:i:s')];

        foreach (['title', 'link'] as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }

        if (empty($fields)) return false;

        $fields[] = "updatedAt = :updatedAt";
        $sql = "UPDATE `Youtubes` SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `Youtubes` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
