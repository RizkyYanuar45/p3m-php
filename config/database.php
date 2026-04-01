<?php
/**
 * Database Connection - PDO Singleton
 * P3M UNIM - PHP Native Backend
 */

require_once __DIR__ . '/config.php';

class Database
{
    private static ?PDO $instance = null;

    /**
     * Get the PDO connection instance (singleton)
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

                self::$instance = new PDO($dsn, DB_USER, DB_PASSWORD, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES    => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND  => "SET NAMES " . DB_CHARSET,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode([
                    'message' => 'Database connection failed',
                    'error'   => APP_ENV === 'development' ? $e->getMessage() : 'Internal server error'
                ]);
                exit;
            }
        }

        return self::$instance;
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}
}
