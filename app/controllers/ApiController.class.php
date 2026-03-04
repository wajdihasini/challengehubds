<?php

abstract class ApiController {
    /**
     * Send a JSON response to the client.
     * 
     * @param mixed $data The data to encode as JSON.
     * @param int $statusCode The HTTP status code.
     */
    protected function jsonResponse($data, $statusCode = 200) {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * Send a JSON error response to the client.
     * 
     * @param string $message The error message.
     * @param int $statusCode The HTTP status code.
     */
    protected function jsonError($message, $statusCode = 400) {
        $this->jsonResponse([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    /**
     * Send a JSON success response to the client.
     * 
     * @param string $message (Optional) Success message.
     * @param mixed $data (Optional) Additional data.
     * @param int $statusCode The HTTP status code.
     */
    protected function jsonSuccess($message = 'Operation successful', $data = null, $statusCode = 200) {
        $response = [
            'status' => 'success',
            'message' => $message
        ];
        if ($data !== null) {
            $response['data'] = $data;
        }
        $this->jsonResponse($response, $statusCode);
    }
}
