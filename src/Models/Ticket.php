<?php

namespace TicketFlow\Models;

class Ticket
{
    private $dataFile;

    public function __construct()
    {
        $this->dataFile = __DIR__ . '/../../data/tickets.json';
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

    public function getAll()
    {
        $content = file_get_contents($this->dataFile);
        return json_decode($content, true) ?: [];
    }

    public function getById($id)
    {
        $tickets = $this->getAll();
        foreach ($tickets as $ticket) {
            if ($ticket['id'] == $id) {
                return $ticket;
            }
        }
        return null;
    }

    public function create($data)
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $tickets = $this->getAll();
        $ticket = [
            'id' => time() . rand(1000, 9999),
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'status' => $data['status'],
            'priority' => $data['priority'] ?? 'medium',
            'createdAt' => date('c'),
            'updatedAt' => date('c')
        ];

        $tickets[] = $ticket;
        $this->saveAll($tickets);

        return ['success' => true, 'ticket' => $ticket];
    }

    public function update($id, $data)
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $tickets = $this->getAll();
        $updated = false;

        foreach ($tickets as $key => $ticket) {
            if ($ticket['id'] == $id) {
                $tickets[$key] = array_merge($ticket, [
                    'title' => $data['title'],
                    'description' => $data['description'] ?? '',
                    'status' => $data['status'],
                    'priority' => $data['priority'] ?? 'medium',
                    'updatedAt' => date('c')
                ]);
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $this->saveAll($tickets);
            return ['success' => true];
        }

        return ['success' => false, 'error' => 'Ticket not found'];
    }

    public function delete($id)
    {
        $tickets = $this->getAll();
        $filtered = array_filter($tickets, function ($ticket) use ($id) {
            return $ticket['id'] != $id;
        });

        if (count($filtered) < count($tickets)) {
            $this->saveAll(array_values($filtered));
            return ['success' => true];
        }

        return ['success' => false, 'error' => 'Ticket not found'];
    }

    private function validate($data)
    {
        $errors = [];

        if (empty(trim($data['title'] ?? ''))) {
            $errors['title'] = 'Title is required';
        }

        $validStatuses = ['open', 'in_progress', 'closed'];
        if (!in_array($data['status'] ?? '', $validStatuses)) {
            $errors['status'] = 'Status must be: open, in_progress, or closed';
        }

        return $errors;
    }

    private function saveAll($tickets)
    {
        file_put_contents($this->dataFile, json_encode($tickets, JSON_PRETTY_PRINT));
    }

    public function getStats()
    {
        $tickets = $this->getAll();
        return [
            'total' => count($tickets),
            'open' => count(array_filter($tickets, fn($t) => $t['status'] === 'open')),
            'in_progress' => count(array_filter($tickets, fn($t) => $t['status'] === 'in_progress')),
            'closed' => count(array_filter($tickets, fn($t) => $t['status'] === 'closed'))
        ];
    }
}
