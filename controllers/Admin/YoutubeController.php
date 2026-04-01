<?php

/**
 * Youtube Controller — Simple CRUD
 */

require_once __DIR__ . '/../../models/YoutubeModel.php';
require_once __DIR__ . '/../../helpers/Response.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

class YoutubeController
{
    private YoutubeModel $model;

    public function __construct()
    {
        $this->model = new YoutubeModel();
    }

    /** GET /api/youtube */
    public function getAll(): void
    {
        try {
            Response::json($this->model->findAll());
        } catch (Exception $e) {
            Response::error('Error fetching videos', 500, $e->getMessage());
        }
    }

    /** GET /api/youtube/{id} */
    public function getById(int $id): void
    {
        try {
            $video = $this->model->findById($id);
            $video ? Response::json($video) : Response::error('Video not found', 404);
        } catch (Exception $e) {
            Response::error('Error fetching video', 500, $e->getMessage());
        }
    }

    /** POST /api/youtube/add */
    public function create(): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            if (empty($input['link'])) Response::error('Link is required', 400);
            $video = $this->model->create($input);
            Response::json($video, 201);
        } catch (Exception $e) {
            Response::error('Error creating video', 500, $e->getMessage());
        }
    }

    /** PATCH /api/youtube/update/{id} */
    public function update(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $video = $this->model->findById($id);
            if (!$video) Response::error('Video not found', 404);
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $this->model->update($id, $input);
            Response::json($this->model->findById($id));
        } catch (Exception $e) {
            Response::error('Error updating video', 500, $e->getMessage());
        }
    }

    /** DELETE /api/youtube/delete/{id} */
    public function delete(int $id): void
    {
        AuthMiddleware::protectAdmin();
        try {
            $video = $this->model->findById($id);
            if (!$video) Response::error('Video not found', 404);
            $this->model->delete($id);
            Response::json(['message' => 'Video deleted successfully']);
        } catch (Exception $e) {
            Response::error('Error deleting video', 500, $e->getMessage());
        }
    }
}
