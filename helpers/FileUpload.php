<?php

/**
 * File Upload Helper
 * P3M UNIM - PHP Native Backend
 * Images saved in original format with UUID filenames.
 */

class FileUpload
{
    /**
     * Generate a UUID v4 string
     */
    private static function uuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Upload an image file
     *
     * @param array  $file       The $_FILES['fieldname'] array
     * @param string $subDir     Subdirectory within uploads/ (e.g., 'articles', 'profiles')
     * @return string|null       The relative path to the saved file, or null on failure
     */
    public static function uploadImage(array $file, string $subDir = ''): ?string
    {
        // Validate file was uploaded
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Validate file size
        if ($file['size'] > MAX_FILE_SIZE) {
            return null;
        }

        // Validate mime type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
            return null;
        }

        // Determine file extension from mime type
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/jpg'  => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];
        $ext = $extensions[$mimeType] ?? 'jpg';

        // Generate unique filename
        $filename = self::uuid() . '.' . $ext;

        // Create target directory if it doesn't exist
        $targetDir = rtrim(UPLOAD_DIR, '/\\');
        if ($subDir) {
            $targetDir .= DIRECTORY_SEPARATOR . $subDir;
        }
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Return relative path for database storage (always forward slashes)
            $relativePath = 'uploads/' . ($subDir ? $subDir . '/' : '') . $filename;
            return $relativePath;
        }

        return null;
    }

    /**
     * Delete a file by its relative path
     */
    public static function deleteFile(?string $relativePath): bool
    {
        if (empty($relativePath)) {
            return false;
        }

        $fullPath = __DIR__ . '/../' . $relativePath;

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }
}
