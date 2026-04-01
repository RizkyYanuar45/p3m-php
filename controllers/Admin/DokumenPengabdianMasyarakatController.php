<?php

require_once __DIR__ . '/../../models/CatDokumenPengabModel.php';
require_once __DIR__ . '/../../models/DokumenPengabModel.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class DokumenPengabdianMasyarakatController
{
    private CatDokumenPengabModel $catModel;
    private DokumenPengabModel $dokModel;
    private string $baseUrl = '/admin/pengabdian/dokumen';

    public function __construct()
    {
        AuthMiddleware::protectAdmin();
        $this->catModel = new CatDokumenPengabModel();
        $this->dokModel = new DokumenPengabModel();
    }

    /**
     * GET /admin/pengabdian/dokumen
     * Render the manage-documents page with categories and documents.
     */
    public function index(): void
    {
        $limit = 10;

        // Category Pagination
        $catPage = (int) ($_GET['cat_page'] ?? 1);
        if ($catPage < 1) $catPage = 1;
        $totalCats = $this->catModel->countAll();
        $totalCatPages = ceil($totalCats / $limit);
        $categories = $this->catModel->findPaginated($catPage, $limit);

        // Document Pagination
        $docPage = (int) ($_GET['doc_page'] ?? 1);
        if ($docPage < 1) $docPage = 1;
        $totalDocs = $this->dokModel->countAll();
        $totalDocPages = ceil($totalDocs / $limit);
        $documents  = $this->dokModel->findPaginated($docPage, $limit);

        require_once __DIR__ . "/../../views/admin/CrudDokumenPengabdianMasyarakat.php";
    }

    // ============ CATEGORY CRUD ============

    /**
     * POST /admin/pengabdian/dokumen/category/tambah
     */
    public function storeCategory(): void
    {
        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            $_SESSION['flash_error'] = 'Nama kategori tidak boleh kosong.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->catModel->create(['name' => $name]);
        $_SESSION['flash_success'] = 'Kategori berhasil ditambahkan.';
        header('Location: ' . $this->baseUrl);
        exit;
    }

    /**
     * POST /admin/pengabdian/dokumen/category/edit
     */
    public function updateCategory(): void
    {
        $id   = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');

        if ($id <= 0 || empty($name)) {
            $_SESSION['flash_error'] = 'Data kategori tidak valid.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->catModel->update($id, ['name' => $name]);
        $_SESSION['flash_success'] = 'Kategori berhasil diperbarui.';
        header('Location: ' . $this->baseUrl);
        exit;
    }

    /**
     * POST /admin/pengabdian/dokumen/category/hapus
     */
    public function destroyCategory(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['flash_error'] = 'Kategori tidak ditemukan.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->catModel->delete($id);
        $_SESSION['flash_success'] = 'Kategori berhasil dihapus.';
        header('Location: ' . $this->baseUrl);
        exit;
    }

    // ============ DOCUMENT CRUD ============

    /**
     * POST /admin/pengabdian/dokumen/tambah
     */
    public function storeDocument(): void
    {
        $fileName = trim($_POST['file_name'] ?? '');
        $fileUrl  = trim($_POST['file_url'] ?? '');
        $catId    = (int) ($_POST['catdokumenpengabId'] ?? 0);

        if (empty($fileName) || empty($fileUrl) || $catId <= 0) {
            $_SESSION['flash_error'] = 'Data dokumen tidak lengkap.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->dokModel->create([
            'file_name'        => $fileName,
            'file_url'         => $fileUrl,
            'catdokumenpengabId' => $catId
        ]);

        $_SESSION['flash_success'] = 'Dokumen berhasil ditambahkan.';
        header('Location: ' . $this->baseUrl);
        exit;
    }

    /**
     * POST /admin/pengabdian/dokumen/edit
     */
    public function updateDocument(): void
    {
        $id       = (int) ($_POST['id'] ?? 0);
        $fileName = trim($_POST['file_name'] ?? '');
        $fileUrl  = trim($_POST['file_url'] ?? '');
        $catId    = (int) ($_POST['catdokumenpengabId'] ?? 0);

        if ($id <= 0 || empty($fileName) || empty($fileUrl) || $catId <= 0) {
            $_SESSION['flash_error'] = 'Data edit dokumen tidak valid.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->dokModel->update($id, [
            'file_name'        => $fileName,
            'file_url'         => $fileUrl,
            'catdokumenpengabId' => $catId
        ]);

        $_SESSION['flash_success'] = 'Dokumen berhasil diperbarui.';
        header('Location: ' . $this->baseUrl);
        exit;
    }

    /**
     * POST /admin/pengabdian/dokumen/hapus
     */
    public function destroyDocument(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['flash_error'] = 'Dokumen tidak ditemukan.';
            header('Location: ' . $this->baseUrl);
            exit;
        }

        $this->dokModel->delete($id);
        $_SESSION['flash_success'] = 'Dokumen berhasil dihapus.';
        header('Location: ' . $this->baseUrl);
        exit;
    }
}
