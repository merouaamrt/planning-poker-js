<?php
class Carte {
    public $valeur;
    public $type;

    public function __construct($valeur, $type = "number") {
        $this->valeur = $valeur;
        $this->type = $type;
    }

    public function isCafe() {
        return $this->type === "cafe" || $this->valeur === "cafe";
    }
}
