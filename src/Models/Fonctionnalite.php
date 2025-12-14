<?php

class Fonctionnalite {
    private string $titre;
    private string $description;
    private ?int $estimationFinale = null;

    public function __construct(string $titre, string $description) {
        $this->titre = $titre;
        $this->description = $description;
    }

    public function setEstimation(int $valeur): void {
        $this->estimationFinale = $valeur;
    }

    public function getEstimation(): ?int {
        return $this->estimationFinale;
    }
}
