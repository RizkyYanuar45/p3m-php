<?php

/**
 * Form Controller — CRUD for form links
 */

require_once __DIR__ . '/../../models/FormModel.php';
require_once __DIR__ . '/../../helpers/Response.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class FormController
{
    private FormModel $model;

    public function __construct()
    {
        $this->model = new FormModel();
    }

    /** GET /api/forms */
    public function getAll(): void
    {
        try {
            Response::json($this->model->findAll());
        } catch (Exception $e) {
            Response::error('Error fetching forms', 500, $e->getMessage());
        }
    }

    /** GET /api/forms/{id} */
    public function getById(int $id): void
    {
        try {
            $form = $this->model->findById($id);
            $form ? Response::json($form) : Response::error('Form not found', 404);
        } catch (Exception $e) {
            Response::error('Error fetching form', 500, $e->getMessage());
        }
    }

    /** POST /api/forms/add */
    public function create(): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $form = $this->model->create($input);
            Response::json($form, 201);
        } catch (Exception $e) {
            Response::error('Error creating form', 500, $e->getMessage());
        }
    }

    /** PATCH /api/forms/update/{id} */
    public function update(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $form = $this->model->findById($id);
            if (!$form) Response::error('Form not found', 404);
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $this->model->update($id, $input);
            Response::json($this->model->findById($id));
        } catch (Exception $e) {
            Response::error('Error updating form', 500, $e->getMessage());
        }
    }

    /** DELETE /api/forms/delete/{id} */
    public function delete(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $form = $this->model->findById($id);
            if (!$form) Response::error('Form not found', 404);
            $this->model->delete($id);
            Response::json(['message' => 'Form deleted successfully']);
        } catch (Exception $e) {
            Response::error('Error deleting form', 500, $e->getMessage());
        }
    }
}
