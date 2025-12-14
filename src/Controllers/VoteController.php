<?php

require_once __DIR__ . '/../Models/Partie.php';

class VoteController {
    private Partie $partie;

    public function __construct(Partie $partie) {
        $this->partie = $partie;
    }

    public function voter(): void {
        $pseudo = $_POST['pseudo'] ?? null;
        $valeur = $_POST['valeur'] ?? null;

        if (!$pseudo || !$valeur) {
            http_response_code(400);
            echo "Paramètres manquants";
            return;
        }

        $this->partie->voter($pseudo, (int)$valeur);
        echo "Vote enregistré";
    }
}
