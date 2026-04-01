<?php

/**
 * File Controller — CRUD for downloadable files (SK Rektor, Panduan, etc.)
 */

require_once __DIR__ . '/../../models/FileModel.php';
require_once __DIR__ . '/../../helpers/Response.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class FileController
{
    private FileModel $model;

    public function __construct()
    {
        $this->model = new FileModel();
    }

    /** GET /api/files */
    public function getAll(): void
    {
        try {
            Response::json($this->model->findAll());
        } catch (Exception $e) {
            Response::error('Error fetching files', 500, $e->getMessage());
        }
    }

    /** GET /api/files/{id} */
    public function getById(int $id): void
    {
        try {
            $file = $this->model->findById($id);
            $file ? Response::json($file) : Response::error('File not found', 404);
        } catch (Exception $e) {
            Response::error('Error fetching file', 500, $e->getMessage());
        }
    }

    /** GET /api/files/type?type= */
    public function getByType(): void
    {
        try {
            $type = $_GET['type'] ?? '';
            if (empty($type)) Response::error("Query parameter 'type' is required", 400);
            Response::json($this->model->findByType($type));
        } catch (Exception $e) {
            Response::error('Error fetching files by type', 500, $e->getMessage());
        }
    }

    /** POST /api/files/add */
    public function create(): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $file = $this->model->create($input);
            Response::json($file, 201);
        } catch (Exception $e) {
            Response::error('Error creating file', 500, $e->getMessage());
        }
    }

    /** PATCH /api/files/update/{id} */
    public function update(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $existing = $this->model->findById($id);
            if (!$existing) Response::error('File not found', 404);
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $this->model->update($id, $input);
            Response::json($this->model->findById($id));
        } catch (Exception $e) {
            Response::error('Error updating file', 500, $e->getMessage());
        }
    }

    /** DELETE /api/files/delete/{id} */
    public function delete(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $existing = $this->model->findById($id);
            if (!$existing) Response::error('File not found', 404);
            $this->model->delete($id);
            Response::json(['message' => 'berhasil dihapus'], 200);
        } catch (Exception $e) {
            Response::error('Error deleting file', 500, $e->getMessage());
        }
    }
}
