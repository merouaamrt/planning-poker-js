<?php

require_once __DIR__ . '/../Services/PartieService.php';

class PartieController {

    private PartieService $service;

    public function __construct() {
        $this->service = new PartieService();
    }

    public function ajouterJoueur() {
        $nom = $_POST['nom'] ?? null;
        if (!$nom) {
            http_response_code(400);
            echo "Nom manquant";
            return;
        }

        $this->service->ajouterJoueur($nom);
        echo "Joueur ajouté";
    }
}
