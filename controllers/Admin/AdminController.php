<?php

/**
 * Admin Controller
 */

require_once __DIR__ . '/../../models/AdminModel.php';
require_once __DIR__ . '/../../helpers/Response.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class AdminController
{
    private AdminModel $model;

    public function __construct()
    {
        $this->model = new AdminModel();
    }

    /** GET /api/admins */
    public function getAll(): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $admins = $this->model->findAll();
            Response::json($admins);
        } catch (Exception $e) {
            Response::error('Error fetching admins', 500, $e->getMessage());
        }
    }

    /** GET /api/admins/{id} */
    public function getById(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $admin = $this->model->findById($id);
            if ($admin) {
                Response::json($admin);
            } else {
                Response::error('Admin not found', 404);
            }
        } catch (Exception $e) {
        }
    }

    /** GET /admin/dashboard */
    public function dashboard(): void
    {
        AuthMiddleware::protectAdmin();

        require_once __DIR__ . '/../../models/ArticleModel.php';
        require_once __DIR__ . '/../../models/FileModel.php';

        $articleModel = new ArticleModel();
        $fileModel = new FileModel();

        // Fetch counts for article categories
        $countPenelitian = $articleModel->countByCategory('informasi_penelitian');
        $countPengabdian = $articleModel->countByCategory('informasi_pengabdian_masyarakat');
        $countPengabdianMandiri = $articleModel->countByCategory('informasi_pengabdian_masyarakat_mandiri');
        $countKKN = $articleModel->countByCategory('informasi_kkn');

        // Fetch total files count
        $totalFiles = $fileModel->countAll();

        $recentArticles = $articleModel->findPaginated(1, 5);

        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }
}
