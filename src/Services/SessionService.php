<?php

require_once __DIR__ . '/../Models/Session.php';

class SessionService {

    public function creerSession(): Session {
        $id = uniqid('session_', true);
        return new Session($id);
    }
}
