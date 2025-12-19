<?php

require_once __DIR__ . '/JsonStorage.php';
require_once __DIR__ . '/../Models/Session.php';

class SessionPersistenceService {

    private string $dir;

    public function __construct(string $dir) {
        $this->dir = $dir;
    }

    private function pathFor(string $sessionId): string {
        return rtrim($this->dir, '/') . '/' . $sessionId . '.json';
    }

    public function save(Session $session): void {
        $storage = new JsonStorage($this->pathFor($session->getId()));
        $storage->save($session->toArray());
    }

    public function load(string $sessionId): ?Session {
        $path = $this->pathFor($sessionId);
        $storage = new JsonStorage($path);
        $data = $storage->load();
        if (!$data) return null;
        return Session::fromArray($data);
    }
}
