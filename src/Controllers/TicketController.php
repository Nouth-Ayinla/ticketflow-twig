<?php

namespace TicketFlow\Controllers;

use TicketFlow\Session;
use TicketFlow\Models\Ticket;

class TicketController
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

        $tickets = $this->ticketModel->getAll();
        $user = Session::getUser();

        echo $this->twig->render('tickets/index.twig', [
            'user' => $user,
            'tickets' => $tickets,
            'success' => Session::getFlash('success'),
            'error' => Session::getFlash('error')
        ]);
    }

    public function create()
    {
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'status' => $_POST['status'] ?? 'open',
                'priority' => $_POST['priority'] ?? 'medium'
            ];

            $result = $this->ticketModel->create($data);

            if ($result['success']) {
                Session::setFlash('success', 'Ticket created successfully');
                header('Location: /tickets');
                exit;
            }

            Session::setFlash('error', implode(', ', $result['errors']));
            header('Location: /tickets');
            exit;
        }

        $user = Session::getUser();
        echo $this->twig->render('tickets/form.twig', [
            'user' => $user,
            'action' => 'create'
        ]);
    }

    public function edit($id)
    {
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        $ticket = $this->ticketModel->getById($id);
        if (!$ticket) {
            Session::setFlash('error', 'Ticket not found');
            header('Location: /tickets');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'status' => $_POST['status'] ?? 'open',
                'priority' => $_POST['priority'] ?? 'medium'
            ];

            $result = $this->ticketModel->update($id, $data);

            if ($result['success']) {
                Session::setFlash('success', 'Ticket updated successfully');
                header('Location: /tickets');
                exit;
            }

            Session::setFlash('error', $result['error'] ?? 'Failed to update ticket');
            header('Location: /tickets/edit/' . $id);
            exit;
        }

        $user = Session::getUser();
        echo $this->twig->render('tickets/form.twig', [
            'user' => $user,
            'ticket' => $ticket,
            'action' => 'edit'
        ]);
    }

    public function delete($id)
    {
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        $result = $this->ticketModel->delete($id);

        if ($result['success']) {
            Session::setFlash('success', 'Ticket deleted successfully');
        } else {
            Session::setFlash('error', 'Failed to delete ticket');
        }

        header('Location: /tickets');
        exit;
    }
}
