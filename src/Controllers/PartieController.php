<?php

require_once __DIR__ . '/../Models/Partie.php';

class PartieController {
    private Partie $partie;

    public function __construct(Partie $partie) {
        $this->partie = $partie;
    }

    public function resultat(): void {
        echo json_encode($this->partie->resultat());
    }
}
