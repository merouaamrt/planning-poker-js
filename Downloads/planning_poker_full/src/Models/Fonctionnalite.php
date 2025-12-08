<?php
class Fonctionnalite {
    public $id;
    public $titre;
    public $description;
    public $estimationFinale = null;
    public $statut = "pending";

    public function __construct($id, $titre, $description = "") {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
    }

    public function setEstimation($valeur) {
        $this->estimationFinale = $valeur;
        $this->statut = "validated";
    }

    public function estValidee() {
        return $this->statut === "validated";
    }
}
