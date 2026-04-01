<?php

/**
 * Article Controller — Full CRUD with image upload & slug generation
 */

require_once __DIR__ . '/../../models/ArticleModel.php';
require_once __DIR__ . '/../../helpers/Response.php';
require_once __DIR__ . '/../../helpers/FileUpload.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class ArticleController
{
    private ArticleModel $model;

    public function __construct()
    {
        $this->model = new ArticleModel();
    }

    /**
     * Generate a unique slug from a title
     */
    private function generateUniqueSlug(string $title): string
    {
        // Transliterate and slugify
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s_]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        if (empty($slug)) {
            $slug = 'article';
        }

        $baseSlug = $slug;
        $counter = 1;
        $maxAttempts = 100;

        for ($i = 0; $i < $maxAttempts; $i++) {
            if (!$this->model->slugExists($slug)) {
                return $slug;
            }
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Fallback
        return $baseSlug . '-' . time();
    }

    /** GET /api/article */
    public function getAll(): void
    {
        try {
            $page = (int) ($_GET['page'] ?? 1);
            if ($page < 1) $page = 1;
            $limit = 10;

            $total = $this->model->countAll();
            $totalPages = ceil($total / $limit);
            $articles = $this->model->findPaginated($page, $limit);

            Response::json([
                'data' => $articles,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages'  => $totalPages,
                    'total_items'  => $total,
                    'limit'        => $limit
                ]
            ]);
        } catch (Exception $e) {
            Response::error('Error fetching articles', 500, $e->getMessage());
        }
    }

    /** GET /api/article/slug/{slug} */
    public function getBySlug(string $slug): void
    {
        try {
            $article = $this->model->findBySlug($slug);
            if (!$article) {
                Response::error('Article not found', 404);
            }
            Response::json($article);
        } catch (Exception $e) {
            Response::error('Error fetching article', 500, $e->getMessage());
        }
    }

    /** GET /api/article/type/{type} */
    public function getByType(string $type): void
    {
        try {
            $articles = $this->model->findByCategory($type);
            Response::json($articles);
        } catch (Exception $e) {
            Response::error('Error fetching articles', 500, $e->getMessage());
        }
    }

    /** POST /api/article/add */
    public function create(): void
    {
        AuthMiddleware::protectAdmin();
        $uploadedFilePath = null;

        try {
            $title    = $_POST['title'] ?? '';
            $content  = $_POST['content'] ?? '';
            $author   = $_POST['author'] ?? 'Anonymous';
            $category = $_POST['category'] ?? 'umum';

            // Handle file upload
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $uploadedFilePath = FileUpload::uploadImage($_FILES['thumbnail'], 'articles');
            }

            // Validation
            if (empty($title)) {
                if ($uploadedFilePath) FileUpload::deleteFile($uploadedFilePath);
                Response::error('Title is required', 400);
            }

            $slug = $this->generateUniqueSlug($title);

            $article = $this->model->create([
                'title'     => $title,
                'slug'      => $slug,
                'content'   => $content,
                'thumbnail' => $uploadedFilePath,
                'author'    => $author,
                'category'  => $category,
            ]);

            Response::success('Article created successfully', $article, 201);
        } catch (Exception $e) {
            if ($uploadedFilePath) FileUpload::deleteFile($uploadedFilePath);
            Response::error('Error creating article', 500, $e->getMessage());
        }
    }

    /** PATCH /api/article/update/{id} */
    public function update(int $id): void
    {
        AuthMiddleware::protectAdmin();
        $newThumbnailPath = null;

        try {
            $article = $this->model->findById($id);
            if (!$article) {
                if (isset($_FILES['thumbnail'])) {
                    // Clean up if uploaded
                }
                Response::error('Article not found', 404);
            }

            $oldThumbnailPath = $article['thumbnail'];

            // Handle file upload
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $newThumbnailPath = FileUpload::uploadImage($_FILES['thumbnail'], 'articles');
            }

            // Build update data
            $updatedData = [];
            if (isset($_POST['title']))    $updatedData['title']    = $_POST['title'];
            if (isset($_POST['content']))  $updatedData['content']  = $_POST['content'];
            if (isset($_POST['author']))   $updatedData['author']   = $_POST['author'];
            if (isset($_POST['category'])) $updatedData['category'] = $_POST['category'];

            // Update slug if title changed
            if (isset($_POST['title']) && $_POST['title'] !== $article['title']) {
                $updatedData['slug'] = $this->generateUniqueSlug($_POST['title']);
            }

            if ($newThumbnailPath) {
                $updatedData['thumbnail'] = $newThumbnailPath;
            }

            if (!empty($updatedData)) {
                $this->model->update($id, $updatedData);
            }

            // Delete old thumbnail if new one was uploaded
            if ($newThumbnailPath && $oldThumbnailPath) {
                FileUpload::deleteFile($oldThumbnailPath);
            }

            $updatedArticle = $this->model->findById($id);
            Response::success('Article updated successfully', $updatedArticle);
        } catch (Exception $e) {
            if ($newThumbnailPath) FileUpload::deleteFile($newThumbnailPath);
            Response::error('Error updating article', 500, $e->getMessage());
        }
    }

    /** DELETE /api/article/delete/{id} */
    public function delete(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $article = $this->model->findById($id);
            if (!$article) {
                Response::error('Article not found', 404);
            }

            $thumbnailPath = $article['thumbnail'];
            $this->model->delete($id);

            if ($thumbnailPath) {
                FileUpload::deleteFile($thumbnailPath);
            }

            Response::success('Article deleted successfully', ['deletedCount' => 1]);
        } catch (Exception $e) {
            Response::error('Error deleting article', 500, $e->getMessage());
        }
    }
}
