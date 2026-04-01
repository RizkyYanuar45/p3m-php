<?php

require_once __DIR__ . '/../../models/ArticleModel.php';
require_once __DIR__ . '/../../helpers/FileUpload.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class InformasiPenelitianController
{
    private ArticleModel $model;
    private string $category = 'informasi_penelitian';

    public function __construct()
    {
        AuthMiddleware::protectAdmin();
        $this->model = new ArticleModel();
    }

    public function index(): void
    {
        $limit = 10;
        $page = (int) ($_GET['page'] ?? 1);
        if ($page < 1) $page = 1;

        $totalItems = $this->model->countByCategory($this->category);
        $totalPages = ceil($totalItems / $limit);
        $articles = $this->model->findPaginatedByCategory($this->category, $page, $limit);

        require_once __DIR__ . '/../../views/admin/CrudInformasiPenelitian.php';
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $now = date('Y-m-d H:i:s');

        if (empty($title) || empty($content)) {
            $_SESSION['flash_error'] = 'Judul dan konten wajib diisi.';
            header('Location: /admin/penelitian/informasi');
            exit;
        }

        // Handle Thumbnail Upload using Helper
        $thumbnail = '';
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $newPath = FileUpload::uploadImage($_FILES['thumbnail'], 'articles');
            if ($newPath) {
                $thumbnail = '/' . $newPath;
            }
        }

        // Generate Slug
        $slug = $this->generateSlug($title);

        $this->model->create([
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'author' => $author ?: 'Admin',
            'published_date' => $now,
            'category' => $this->category,
            'thumbnail' => $thumbnail
        ]);

        $_SESSION['flash_success'] = 'Artikel informasi penelitian berhasil ditambahkan.';
        header('Location: /admin/penelitian/informasi');
        exit;
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $author = trim($_POST['author'] ?? '');

        if ($id <= 0 || empty($title) || empty($content)) {
            $_SESSION['flash_error'] = 'Data tidak valid.';
            header('Location: /admin/penelitian/informasi');
            exit;
        }

        $article = $this->model->findById($id);
        if (!$article) {
            $_SESSION['flash_error'] = 'Artikel tidak ditemukan.';
            header('Location: /admin/penelitian/informasi');
            exit;
        }

        $data = [
            'title' => $title,
            'content' => $content,
            'author' => $author ?: 'Admin'
        ];

        // Handle Thumbnail Update using Helper
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $newPath = FileUpload::uploadImage($_FILES['thumbnail'], 'articles');
            if ($newPath) {
                // Delete old thumbnail if exists
                if (!empty($article['thumbnail'])) {
                    FileUpload::deleteFile(ltrim($article['thumbnail'], '/'));
                }
                $data['thumbnail'] = '/' . $newPath;
            }
        }

        $this->model->update($id, $data);

        $_SESSION['flash_success'] = 'Artikel informasi penelitian berhasil diperbarui.';
        header('Location: /admin/penelitian/informasi');
        exit;
    }

    public function destroy(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID tidak valid.';
            header('Location: /admin/penelitian/informasi');
            exit;
        }

        $article = $this->model->findById($id);
        if ($article && !empty($article['thumbnail'])) {
            FileUpload::deleteFile(ltrim($article['thumbnail'], '/'));
        }

        $this->model->delete($id);
        $_SESSION['flash_success'] = 'Artikel informasi penelitian berhasil dihapus.';
        header('Location: /admin/penelitian/informasi');
        exit;
    }

    private function generateSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $i = 1;
        while ($this->model->slugExists($slug)) {
            $slug = $originalSlug . '-' . $i++;
        }
        return $slug;
    }
}
