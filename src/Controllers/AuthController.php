<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../JwtHelper.php';

class AuthController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->username, $data->password)) {
            $username = $data->username;
            $password = $data->password;

            $user = $this->user->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $payload = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'exp' => time() + (60 * 60) // Token expires in 1 hour
                ];

                $jwt = JwtHelper::encode($payload);

                http_response_code(200);
                echo json_encode(['token' => $jwt]);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Invalid credentials.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Incomplete login data.']);
        }
    }

    public function register()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->username, $data->password)) {
            $username = $data->username;
            $password = password_hash($data->password, PASSWORD_BCRYPT);

            if ($this->user->create($username, $password)) {
                http_response_code(201);
                echo json_encode(['message' => 'User registered successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to register user.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Incomplete registration data.']);
        }
    }
}
