<?php

require_once __DIR__ . '/../Services/VoteService.php';

class VoteController {

    private VoteService $service;

    public function __construct() {
        $this->service = new VoteService();
    }

    public function voter() {
        $joueur = $_POST['joueur'] ?? null;
        $valeur = intval($_POST['valeur'] ?? -1);

        if (!$joueur || $valeur < 0) {
            http_response_code(400);
            echo "Paramètres invalides";
            return;
        }

        $this->service->ajouterVote($joueur, $valeur);
        echo "Vote enregistré";
    }

    public function reset() {
        $this->service->resetVotes();
        echo "Votes réinitialisés";
    }
}
