<?php
require_once __DIR__ . '/../../models/FileModel.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class PanduanLayananHKIController
{
    private FileModel $model;
    private string $fileType = 'panduan_layanan_hki';
    private string $baseUrl = '/admin/panduan-layanan-hki';

    public function __construct()
    {
        AuthMiddleware::protectAdmin();
        $this->model = new FileModel();
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $totalItems = $this->model->countByType($this->fileType);
        $totalPages = ceil($totalItems / $limit);
        $files = $this->model->findPaginatedByType($this->fileType, $page, $limit);

        require_once __DIR__ . '/../../views/admin/CrudPanduanLayananHKI.php';
    }

    public function store()
    {
        $data = [
            'file_name' => $_POST['file_name'] ?? '',
            'file_url' => $_POST['file_url'] ?? '',
            'file_description' => $_POST['file_description'] ?? '',
            'file_type' => $this->fileType
        ];

        if ($this->model->create($data)) {
            $_SESSION['flash_success'] = "Berhasil menambah panduan layanan HKI.";
        } else {
            $_SESSION['flash_error'] = "Gagal menambah panduan layanan HKI.";
        }
        header("Location: " . $this->baseUrl);
        exit;
    }

    public function update()
    {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'file_name' => $_POST['file_name'] ?? '',
            'file_url' => $_POST['file_url'] ?? '',
            'file_description' => $_POST['file_description'] ?? ''
        ];

        if ($this->model->update($id, $data)) {
            $_SESSION['flash_success'] = "Berhasil memperbarui panduan layanan HKI.";
        } else {
            $_SESSION['flash_error'] = "Gagal memperbarui panduan layanan HKI.";
        }
        header("Location: " . $this->baseUrl);
        exit;
    }

    public function destroy()
    {
        $id = (int)($_POST['id'] ?? 0);
        if ($this->model->delete($id)) {
            $_SESSION['flash_success'] = "Berhasil menghapus panduan layanan HKI.";
        } else {
            $_SESSION['flash_error'] = "Gagal menghapus panduan layanan HKI.";
        }
        header("Location: " . $this->baseUrl);
        exit;
    }
}
