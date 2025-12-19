<?php

require_once __DIR__ . '/../Services/SessionService.php';
require_once __DIR__ . '/../Services/SessionPersistenceService.php';

class SessionController {

    private SessionService $service;
    private SessionPersistenceService $persistence;

    public function __construct() {
        $this->service = new SessionService();
        $this->persistence = new SessionPersistenceService(__DIR__ . '/../../data/sessions');
    }

    public function creer(): void {
        $session = $this->service->creerSession();
        $this->persistence->save($session);

        echo json_encode([
            'status' => 'ok',
            'session_id' => $session->getId()
        ]);
    }

    public function get(): void {
        $sessionId = $_GET['session_id'] ?? null;
        if (!$sessionId) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'session_id manquant']);
            return;
        }

        $session = $this->persistence->load($sessionId);
        if (!$session) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'session introuvable']);
            return;
        }

        echo json_encode(['status' => 'ok', 'session' => $session->toArray()]);
    }
}
