<?php

require_once __DIR__ . '/../Services/SessionService.php';

class SessionController {

    private SessionService $service;

    public function __construct() {
        $this->service = new SessionService();
    }

    public function creer(): void {
        $session = $this->service->creerSession();
        echo json_encode([
            'session_id' => $session->getId()
        ]);
    }
}
