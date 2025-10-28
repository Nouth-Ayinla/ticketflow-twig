<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TicketFlow\Session;
use TicketFlow\Controllers\AuthController;
use TicketFlow\Controllers\DashboardController;
use TicketFlow\Controllers\TicketController;

// Initialize Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'debug' => true
]);

$twig->addExtension(new \Twig\Extension\DebugExtension());

// Start session and CSRF protection
Session::start();

// Generate CSRF token if not exists
if (!Session::has('csrf_token')) {
    Session::set('csrf_token', bin2hex(random_bytes(32)));
}

// Simple routing
$route = $_GET['route'] ?? $_SERVER['REQUEST_URI'] ?? '/';
$route = parse_url($route, PHP_URL_PATH);
$route = rtrim($route, '/');
$route = $route ?: '/';

// Route matching with enhanced security
switch (true) {
    // Landing page
    case $route === '/' || $route === '/landing':
        if (Session::isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }
        echo $twig->render('landing.twig', ['csrf_token' => Session::get('csrf_token')]);
        break;

    // Auth routes
    case $route === '/login' && $_SERVER['REQUEST_METHOD'] === 'GET':
        if (Session::isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }
        $controller = new AuthController($twig);
        $controller->showLogin();
        break;

    case $route === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST':
        $controller = new AuthController($twig);
        $controller->login();
        break;

    case $route === '/signup' && $_SERVER['REQUEST_METHOD'] === 'GET':
        if (Session::isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }
        $controller = new AuthController($twig);
        $controller->showSignup();
        break;

    case $route === '/signup' && $_SERVER['REQUEST_METHOD'] === 'POST':
        $controller = new AuthController($twig);
        $controller->signup();
        break;

    case $route === '/logout':
        $controller = new AuthController($twig);
        $controller->logout();
        break;

    // Protected routes
    case $route === '/dashboard':
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
        $controller = new DashboardController($twig);
        $controller->index();
        break;

    case $route === '/tickets':
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
        $controller = new TicketController($twig);
        $controller->index();
        break;

    case $route === '/tickets/create':
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
        $controller = new TicketController($twig);
        $controller->create();
        break;

    case preg_match('/^\/tickets\/edit\/(\d+)$/', $route, $matches):
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
        $controller = new TicketController($twig);
        $controller->edit($matches[1]);
        break;

    case preg_match('/^\/tickets\/delete\/(\d+)$/', $route, $matches):
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
        $controller = new TicketController($twig);
        $controller->delete($matches[1]);
        break;

    // 404
    default:
        http_response_code(404);
        echo $twig->render('layout.twig', [
            'content' => '<div class="text-center py-16"><h1 class="text-4xl font-bold text-gray-800 mb-4">404 - Page Not Found</h1><p class="text-gray-600">The page you are looking for does not exist.</p><a href="/" class="text-blue-600 hover:underline">Go back home</a></div>',
            'csrf_token' => Session::get('csrf_token')
        ]);
        break;
}
