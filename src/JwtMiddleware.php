<?php

require_once __DIR__ . '/JwtHelper.php';

class JwtMiddleware
{
    public static function authenticate()
    {
        // Get the Authorization header
        $headers = apache_request_headers();
        
        if (isset($headers['Authorization'])) {
            // Remove "Bearer " from the header value
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            
            try {
                // Decode the token
                $decoded = JwtHelper::decode($token);
                
                // Optionally, you can add more checks here, like verifying the user exists in the database.
                
                // If the token is valid, return true
                return true;
            } catch (Exception $e) {
                // Token is invalid
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized: Invalid token.']);
                exit();
            }
        } else {
            // No token provided
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized: No token provided.']);
            exit();
        }
    }
}
