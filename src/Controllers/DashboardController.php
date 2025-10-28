<?php

namespace TicketFlow\Controllers;

use TicketFlow\Session;
use TicketFlow\Models\Ticket;

class DashboardController
{
    private $twig;
    private $ticketModel;

    public function __construct($twig)
    {
        $this->twig = $twig;
        $this->ticketModel = new Ticket();
    }

    public function index()
    {
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        $stats = $this->ticketModel->getStats();
        $user = Session::getUser();

        echo $this->twig->render('dashboard.twig', [
            'user' => $user,
            'stats' => $stats
        ]);
    }
}
