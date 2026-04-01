<?php

/**
 * Authentication Middleware - Session-based
 * P3M UNIM - PHP Native Backend
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Response.php';

class AuthMiddleware
{
    /**
     * Check if admin is authenticated via session.
     * Call this at the beginning of any protected endpoint.
     * Returns the admin data array if authenticated, or sends a 401 response and exits.
     *
     * @return array Admin data ['id' => ..., 'name' => ..., 'email' => ...]
     */
    public static function protectAdmin(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if session has admin_id
        if (empty($_SESSION['admin_id'])) {
            // If not an API request, redirect to login page
            if (strpos($_SERVER['REQUEST_URI'], '/api/') !== 0) {
                header('Location: /admin/login');
                exit;
            }
            Response::error('Token Kadaluwarsa Silahkan Login Ulang', 401);
        }

        // Verify admin still exists in database
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT id, username FROM Admins WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $_SESSION['admin_id']]);
            $admin = $stmt->fetch();

            if (!$admin) {
                // Admin was deleted after login
                session_destroy();
                if (strpos($_SERVER['REQUEST_URI'], '/api/') !== 0) {
                    header('Location: /admin/login');
                    exit;
                }
                Response::error('Forbidden: Invalid session', 403);
            }

            return $admin;
        } catch (PDOException $e) {
            Response::error('Internal server error', 500, $e->getMessage());
        }

        // Should never reach here, but just in case
        Response::error('Internal server error', 500);
        return []; // Unreachable but satisfies return type
    }
}
