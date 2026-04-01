<?php

require_once __DIR__ . '/../../models/YoutubeModel.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class LuaranP3MController
{
    private YoutubeModel $model;

    public function __construct()
    {
        AuthMiddleware::protectAdmin();
        $this->model = new YoutubeModel();
    }

    public function index(): void
    {
        $limit = 3;
        $page = (int) ($_GET['page'] ?? 1);
        if ($page < 1) $page = 1;

        $totalItems = $this->model->countAll();
        $totalPages = ceil($totalItems / $limit);
        $videos = $this->model->findPaginated($page, $limit);

        require_once __DIR__ . '/../../views/admin/CrudLuaranP3M.php';
    }

    private function formatYoutubeEmbedUrl(string $url): string
    {
        $url = trim($url);
        if (empty($url)) return '';

        // If already an embed link, return as is
        if (strpos($url, 'youtube.com/embed/') !== false) {
            return $url;
        }

        $videoId = '';

        // Case watch?v=
        if (preg_match('/[\\?&]v=([^&#?]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Case youtu.be/
        elseif (preg_match('/youtu\\.be\\/([^&#?]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Case youtube.com/v/
        elseif (preg_match('/\\/v\\/([^&#?]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }

        return $url;
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $link = $this->formatYoutubeEmbedUrl($_POST['link'] ?? '');

        if (empty($title) || empty($link)) {
            $_SESSION['flash_error'] = 'Judul dan link video wajib diisi.';
            header('Location: /admin/profile/luaran-p3m');
            exit;
        }

        $this->model->create([
            'title' => $title,
            'link' => $link
        ]);

        $_SESSION['flash_success'] = 'Video luaran berhasil ditambahkan.';
        header('Location: /admin/profile/luaran-p3m');
        exit;
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $link = $this->formatYoutubeEmbedUrl($_POST['link'] ?? '');

        if ($id <= 0 || empty($title) || empty($link)) {
            $_SESSION['flash_error'] = 'Data tidak valid.';
            header('Location: /admin/profile/luaran-p3m');
            exit;
        }

        $this->model->update($id, [
            'title' => $title,
            'link' => $link
        ]);

        $_SESSION['flash_success'] = 'Video luaran berhasil diperbarui.';
        header('Location: /admin/profile/luaran-p3m');
        exit;
    }

    public function destroy(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID tidak valid.';
            header('Location: /admin/profile/luaran-p3m');
            exit;
        }

        $this->model->delete($id);
        $_SESSION['flash_success'] = 'Video luaran berhasil dihapus.';
        header('Location: /admin/profile/luaran-p3m');
        exit;
    }
}
