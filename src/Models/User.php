<?php

namespace TicketFlow\Models;

class User
{
    private $dataFile;

    public function __construct()
    {
        $this->dataFile = __DIR__ . '/../../data/users.json';
        $this->ensureDataFileExists();
    }

    private function ensureDataFileExists()
    {
        $dir = dirname($this->dataFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, json_encode([]));
        }
    }

    public function authenticate($email, $password)
    {
        // Simulated authentication
        if (!empty($email) && strlen($password) >= 6) {
            $user = [
                'email' => $email,
                'id' => time(),
                'loginTime' => date('c')
            ];
            return ['success' => true, 'user' => $user];
        }
        return ['success' => false, 'error' => 'Invalid credentials. Password must be at least 6 characters.'];
    }

    public function register($email, $password, $confirmPassword)
    {
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Please enter a valid email address'];
        }

        // Validate password match
        if ($password !== $confirmPassword) {
            return ['success' => false, 'error' => 'Passwords do not match'];
        }

        // Validate password length
        if (strlen($password) < 6) {
            return ['success' => false, 'error' => 'Password must be at least 6 characters'];
        }

        // Proceed with authentication
        return $this->authenticate($email, $password);
    }

    private function getUsers()
    {
        $content = file_get_contents($this->dataFile);
        return json_decode($content, true) ?: [];
    }

    private function saveUsers($users)
    {
        file_put_contents($this->dataFile, json_encode($users, JSON_PRETTY_PRINT));
    }
}
