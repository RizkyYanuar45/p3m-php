<?php

require_once __DIR__ . '/../../models/FileModel.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class BukuPanduanKKNBEMController
{
    private FileModel $model;
    private string $fileType = 'panduan_kkn_pkn_bem';
    private string $baseUrl = '/admin/kkn/panduan-bem';

    public function __construct()
    {
        AuthMiddleware::protectAdmin();
        $this->model = new FileModel();
    }

    public function index(): void
    {
        $limit = 10;
        $page = (int) ($_GET['page'] ?? 1);
        if ($page < 1) $page = 1;

        $totalItems = $this->model->countByType($this->fileType);
        $totalPages = ceil($totalItems / $limit);
        $files = $this->model->findPaginatedByType($this->fileType, $page, $limit);

        require_once __DIR__ . "/../../views/admin/CrudBukuPanduanKKNBEM.php";
    }

    public function store(): void
    {
        $name = trim($_POST['file_name'] ?? '');
        $url = trim($_POST['file_url'] ?? '');
        $description = trim($_POST['file_description'] ?? '');

        if (empty($name) || empty($url)) {
            $_SESSION['flash_error'] = 'Nama file dan link GDrive wajib diisi.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->model->create([
            'file_name' => $name,
            'file_url' => $url,
            'file_description' => $description,
            'file_type' => $this->fileType
        ]);

        $_SESSION['flash_success'] = 'Buku Panduan BEM berhasil ditambahkan.';
        header('Location: ' . $this->baseUrl);
        exit;
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['file_name'] ?? '');
        $url = trim($_POST['file_url'] ?? '');
        $description = trim($_POST['file_description'] ?? '');

        if ($id <= 0 || empty($name) || empty($url)) {
            $_SESSION['flash_error'] = 'Data tidak valid.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->model->update($id, [
            'file_name' => $name,
            'file_url' => $url,
            'file_description' => $description
        ]);

        $_SESSION['flash_success'] = 'Buku Panduan BEM berhasil diperbarui.';
        header('Location: ' . $this->baseUrl);
        exit;
    }

    public function destroy(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID tidak valid.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->model->delete($id);
        $_SESSION['flash_success'] = 'Buku Panduan BEM berhasil dihapus.';
        header('Location: ' . $this->baseUrl);
        exit;
    }
}
