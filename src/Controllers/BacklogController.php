<?php

require_once __DIR__ . '/../Services/PartieService.php';

class BacklogController {

    private PartieService $service;

    public function __construct() {
        $this->service = new PartieService();
    }

    public function afficher() {
        header('Content-Type: application/json');
        echo json_encode($this->service->getBacklog()->getTaches());
    }
}
