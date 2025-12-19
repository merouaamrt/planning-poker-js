<?php

require_once __DIR__ . '/../Models/Backlog.php';

class BacklogController {

    public function get(): void {
        $backlog = new Backlog(1, __DIR__ . '/../../data/backlog.json');
        $backlog->chargerDepuisJson();

        echo json_encode([
            'status' => 'ok',
            'backlog' => $backlog->toArray()
        ]);
    }
}
