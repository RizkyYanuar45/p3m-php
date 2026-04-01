<?php
/**
 * JSON Response Helper
 * P3M UNIM - PHP Native Backend
 */

class Response
{
    /**
     * Send a JSON response
     */
    public static function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Send a success response
     */
    public static function success(string $message, $data = null, int $statusCode = 200): void
    {
        $response = ['success' => true, 'message' => $message];
        if ($data !== null) {
            $response['data'] = $data;
        }
        self::json($response, $statusCode);
    }

    /**
     * Send an error response
     */
    public static function error(string $message, int $statusCode = 500, ?string $detail = null): void
    {
        $response = ['message' => $message];
        if ($detail !== null && APP_ENV === 'development') {
            $response['error'] = $detail;
        }
        self::json($response, $statusCode);
    }
}
