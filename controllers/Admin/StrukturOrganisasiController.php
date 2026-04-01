<?php

require_once __DIR__ . '/../../models/ProfileModel.php';
require_once __DIR__ . '/../../helpers/FileUpload.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class StrukturOrganisasiController
{
    private ProfileModel $model;

    public function __construct()
    {
        AuthMiddleware::protectAdmin();
        $this->model = new ProfileModel();
    }

    public function index(): void
    {
        $struktur = $this->model->findOneByType('struktur_organisasi');
        require_once __DIR__ . '/../../views/admin/CrudStrukturOrganisasi.php';
    }

    public function update(): void
    {
        $struktur = $this->model->findOneByType('struktur_organisasi');
        $imageUrl = $struktur['image'] ?? '';

        // Handle Image Upload using Helper
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Use 'profiles' subdirectory as it already exists in root /uploads
            $newImageUrl = FileUpload::uploadImage($_FILES['image'], 'profiles');

            if ($newImageUrl) {
                // Delete old file if exists (Helper uses relative path from root/uploads)
                if ($imageUrl) {
                    // Remove leading slash if present for deleteFile helper which expects relative path from project root
                    $oldRelativePath = ltrim($imageUrl, '/');
                    FileUpload::deleteFile($oldRelativePath);
                }
                // Save path with leading slash for web consistency
                $imageUrl = '/' . $newImageUrl;
            } else {
                $_SESSION['flash_error'] = 'Gagal mengunggah gambar. Pastikan format benar (JPG/PNG/WebP) dan ukuran < 10MB.';
                header('Location: /admin/profile/struktur-organisasi');
                exit;
            }
        }

        if ($struktur) {
            $this->model->update($struktur['id'], ['image' => $imageUrl, 'alt' => 'Struktur Organisasi P3M']);
        } else {
            $this->model->create(['image' => $imageUrl, 'alt' => 'Struktur Organisasi P3M', 'type' => 'struktur_organisasi']);
        }

        $_SESSION['flash_success'] = 'Struktur organisasi berhasil diperbarui.';
        header('Location: /admin/profile/struktur-organisasi');
        exit;
    }
}
