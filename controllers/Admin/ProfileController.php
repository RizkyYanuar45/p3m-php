<?php

/**
 * Profile Controller — CRUD with image upload
 */

require_once __DIR__ . '/../../models/ProfileModel.php';
require_once __DIR__ . '/../../helpers/Response.php';
require_once __DIR__ . '/../../helpers/FileUpload.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class ProfileController
{
    private ProfileModel $model;

    public function __construct()
    {
        $this->model = new ProfileModel();
    }

    /** GET /api/profile */
    public function getAll(): void
    {
        try {
            Response::json($this->model->findAll());
        } catch (Exception $e) {
            Response::error('Error fetching profiles', 500, $e->getMessage());
        }
    }

    /** GET /api/profile/{id} */
    public function getById(int $id): void
    {
        try {
            $profile = $this->model->findById($id);
            $profile ? Response::json($profile) : Response::error('Profile not found', 404);
        } catch (Exception $e) {
            Response::error('Error fetching profile', 500, $e->getMessage());
        }
    }

    /** GET /api/profile/type?type= */
    public function getByType(): void
    {
        try {
            $type = $_GET['type'] ?? '';
            if (empty($type)) {
                Response::error("Query parameter 'type' is required", 400);
            }
            $profiles = $this->model->findByType($type);
            if (empty($profiles)) {
                Response::error('No profiles found for this type', 404);
            }
            Response::json($profiles);
        } catch (Exception $e) {
            Response::error('Error fetching profiles by type', 500, $e->getMessage());
        }
    }

    /** POST /api/profile/add */
    public function create(): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $alt  = $_POST['alt'] ?? '';
            $type = $_POST['type'] ?? '';

            // Check if type already exists
            $existing = $this->model->findOneByType($type);
            if ($existing) {
                Response::error('Foto Sudah ada, silahkan ubah atau hapus foto sebelumnya', 400);
            }

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imagePath = FileUpload::uploadImage($_FILES['image'], 'profiles');
            }

            if (!$type || !$imagePath) {
                Response::error('Image and type are required', 400);
            }

            $profile = $this->model->create(['image' => $imagePath, 'alt' => $alt, 'type' => $type]);
            Response::json($profile, 201);
        } catch (Exception $e) {
            Response::error('Error creating profile', 500, $e->getMessage());
        }
    }

    /** PATCH /api/profile/update/{id} */
    public function update(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $profile = $this->model->findById($id);
            if (!$profile) Response::error('Profile not found', 404);

            $oldImagePath = $profile['image'];
            $updatedData = [];
            if (isset($_POST['alt']))  $updatedData['alt']  = $_POST['alt'];
            if (isset($_POST['type'])) $updatedData['type'] = $_POST['type'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $updatedData['image'] = FileUpload::uploadImage($_FILES['image'], 'profiles');
            }

            if (!empty($updatedData)) {
                $this->model->update($id, $updatedData);
            }

            if (isset($updatedData['image']) && $oldImagePath) {
                FileUpload::deleteFile($oldImagePath);
            }

            Response::json($this->model->findById($id));
        } catch (Exception $e) {
            Response::error('Error updating profile', 500, $e->getMessage());
        }
    }

    /** DELETE /api/profile/delete/{id} */
    public function delete(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $profile = $this->model->findById($id);
            if (!$profile) Response::error('Profile not found', 404);

            $imagePath = $profile['image'];
            $this->model->delete($id);
            if ($imagePath) FileUpload::deleteFile($imagePath);

            Response::json($profile);
        } catch (Exception $e) {
            Response::error('Error deleting profile', 500, $e->getMessage());
        }
    }
}
