<?php

class Joueur {
    public string $nom;
    public ?int $vote = null;

    public function __construct(string $nom) {
        $this->nom = $nom;
    }

    public function choisirCarte(int $valeur): void {
        $this->vote = $valeur;
    }

    public function resetVote(): void {
        $this->vote = null;
    }
}
