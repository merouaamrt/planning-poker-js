<?php

class Carte {
    private int $valeur;
    private string $type;

    public function __construct(int $valeur, string $type = 'standard') {
        $this->valeur = $valeur;
        $this->type = $type;
    }

   
}
