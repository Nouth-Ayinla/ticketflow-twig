<?php

namespace TicketFlow\Controllers;

use TicketFlow\Session;
use TicketFlow\Models\User;

class AuthController
{
    private $twig;
    private $userModel;

    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->userModel = new User();
    }

    public function showLogin()
    {
        if (Session::isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }

        echo $this->twig->render('auth/login.twig', [
            'error' => Session::getFlash('error'),
            'success' => Session::getFlash('success')
        ]);
    }

    public function showSignup()
    {
        if (Session::isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }

        echo $this->twig->render('auth/signup.twig', [
            'error' => Session::getFlash('error')
        ]);
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = $this->userModel->authenticate($email, $password);

        if ($result['success']) {
            Session::setUser($result['user']);
            Session::setFlash('success', 'Login successful!');
            header('Location: /dashboard');
            exit;
        }

        Session::setFlash('error', $result['error']);
        header('Location: /login');
        exit;
    }

    public function signup()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $result = $this->userModel->register($email, $password, $confirmPassword);

        if ($result['success']) {
            Session::setUser($result['user']);
            Session::setFlash('success', 'Account created successfully!');
            header('Location: /dashboard');
            exit;
        }

        Session::setFlash('error', $result['error']);
        header('Location: /signup');
        exit;
    }

    public function logout()
    {
        Session::logout();
        Session::setFlash('success', 'Logged out successfully');
        header('Location: /');
        exit;
    }
}
