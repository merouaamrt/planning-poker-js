<?php
class Joueur {
    public $id;
    public $pseudo;
    public $carteChoisie = null;
    public $estConnecte = true;

    public function __construct($id, $pseudo) {
        $this->id = $id;
        $this->pseudo = $pseudo;
    }

    public function choisirCarte($valeur) {
        $this->carteChoisie = $valeur;
    }

    public function resetVote() {
        $this->carteChoisie = null;
    }
}
