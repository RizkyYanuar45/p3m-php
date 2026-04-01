<?php

/**
 * Article Model
 * Table: Articles
 */

require_once __DIR__ . '/../config/database.php';

class ArticleModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM `Articles` ORDER BY published_date DESC");
        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM `Articles`");
        return (int) $stmt->fetchColumn();
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT * FROM `Articles` ORDER BY published_date DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `Articles` WHERE slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByCategory(string $category): array
    {
        $stmt = $this->db->prepare("SELECT * FROM `Articles` WHERE category = :category ORDER BY published_date DESC");
        $stmt->execute([':category' => $category]);
        return $stmt->fetchAll();
    }

    public function countByCategory(string $category): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM `Articles` WHERE category = :category");
        $stmt->execute([':category' => $category]);
        return (int) $stmt->fetchColumn();
    }

    public function findPaginatedByCategory(string $category, int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT * FROM `Articles` WHERE category = :category ORDER BY published_date DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `Articles` WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function slugExists(string $slug): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as cnt FROM `Articles` WHERE slug = :slug");
        $stmt->execute([':slug' => $slug]);
        $row = $stmt->fetch();
        return (int) $row['cnt'] > 0;
    }

    public function create(array $data): ?array
    {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("
            INSERT INTO `Articles` (title, content, thumbnail, slug, published_date, author, category, createdAt, updatedAt)
            VALUES (:title, :content, :thumbnail, :slug, :published_date, :author, :category, :createdAt, :updatedAt)
        ");
        $stmt->execute([
            ':title'          => $data['title'] ?? '',
            ':content'        => $data['content'] ?? '',
            ':thumbnail'      => $data['thumbnail'] ?? '',
            ':slug'           => $data['slug'] ?? '',
            ':published_date' => $data['published_date'] ?? $now,
            ':author'         => $data['author'] ?? 'Anonymous',
            ':category'       => $data['category'] ?? 'umum',
            ':createdAt'      => $now,
            ':updatedAt'      => $now,
        ]);
        return $this->findById((int) $this->db->lastInsertId());
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id, ':updatedAt' => date('Y-m-d H:i:s')];

        foreach (['title', 'content', 'thumbnail', 'slug', 'author', 'category', 'published_date'] as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }

        if (empty($fields)) {
            return false;
        }

        $fields[] = "updatedAt = :updatedAt";
        $sql = "UPDATE `Articles` SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM `Articles` WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function findRelatedArticles(string $category, int $excludeId, int $limit = 3): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM `Articles` 
            WHERE category = :category AND id != :excludeId 
            ORDER BY published_date DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':excludeId', $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchArticles(string $query, int $limit = 10, int $offset = 0): array
    {
        $searchTerm = "%$query%";
        $stmt = $this->db->prepare("
            SELECT * FROM `Articles` 
            WHERE title LIKE :query 
            ORDER BY published_date DESC 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':query', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countSearchResults(string $query): int
    {
        $searchTerm = "%$query%";
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM `Articles` WHERE title LIKE :query");
        $stmt->execute([':query' => $searchTerm]);
        return (int) $stmt->fetchColumn();
    }

    public function findPaginatedFiltered(string $query = '', string $category = '', int $page = 1, int $limit = 12): array
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM `Articles` WHERE 1=1";
        $params = [];

        if ($query !== '') {
            $sql .= " AND title LIKE :query";
            $params[':query'] = "%$query%";
        }

        if ($category !== '' && $category !== 'semua') {
            $sql .= " AND category = :category";
            $params[':category'] = $category;
        }

        $sql .= " ORDER BY published_date DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countFiltered(string $query = '', string $category = ''): int
    {
        $sql = "SELECT COUNT(*) FROM `Articles` WHERE 1=1";
        $params = [];

        if ($query !== '') {
            $sql .= " AND title LIKE :query";
            $params[':query'] = "%$query%";
        }

        if ($category !== '' && $category !== 'semua') {
            $sql .= " AND category = :category";
            $params[':category'] = $category;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }
}
