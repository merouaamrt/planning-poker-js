<?php

class Fonctionnalite {
    public string $nom;
    public ?int $estimation = null;

    public function __construct(string $nom) {
        $this->nom = $nom;
    }
}
