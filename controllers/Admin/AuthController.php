<?php

/**
 * Auth Controller — Session-based
 */

require_once __DIR__ . '/../../models/AdminModel.php';
require_once __DIR__ . '/../../helpers/Response.php';

class AuthController
{
    private AdminModel $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    /**
     * Monolithic Login: GET renders view, POST handles login
     */
    public function login(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../../views/admin/login.php';
            return;
        }


        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $captcha  = $_POST['captcha'] ?? '';


        // Start session if not started, since we need it for captcha check
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Dynamic Captcha Validation
        $expectedCaptcha = $_SESSION['captcha_answer'] ?? null;

        if ($expectedCaptcha === null || intval($captcha) !== $expectedCaptcha) {
            $error = 'Captcha salah!';
            require_once __DIR__ . '/../../views/admin/login.php';
            return;
        }

        if (empty($username) || empty($password)) {
            $error = 'Username dan password wajib diisi!';
            require_once __DIR__ . '/../../views/admin/login.php';
            return;
        }

        try {
            $admin = $this->adminModel->findByUsername($username);
            
            $isValidPassword = false;
            if ($admin) {
                $isValidPassword = password_verify($password, $admin['password'] ?? '');
                
                // Fallback ekstrim jika driver database Rumahweb masih menukar-nukar urutan kolom:
                if (!$isValidPassword) {
                    foreach ($admin as $key => $val) {
                        if (is_string($val) && password_verify($password, $val)) {
                            $isValidPassword = true;
                            // Set ulang atribut yang benar agar session berjalan normal
                            $admin['username'] = $username;
                            break;
                        }
                    }
                }
            }

            if (!$admin || !$isValidPassword) {
                $error = 'Username atau password salah!';
                require_once __DIR__ . '/../../views/admin/login.php';
                return;
            }
        } catch (Exception $e) {
            $error = 'Terjadi kesalahan sistem: ' . $e->getMessage();
            require_once __DIR__ . '/../../views/admin/login.php';
            return;
        }

        $_SESSION['admin_id']       = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        
        header('Location: /admin/dashboard');
        exit;
    }

    /**
     * Monolithic Logout
     */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header('Location: /admin/login');
        exit;
    }
}
