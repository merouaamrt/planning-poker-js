<?php

class Joueur {
    public int $id;
    public string $pseudo;
    public ?int $vote = null;
    public bool $estConnecte = true;



    public function __construct(int $id,string $pseudo) {
        $this->pseudo = $pseudo;
        $this->id = $id;
    }

    

    public function voter(int $valeur): void {
        $this->vote = $valeur;
    }

    public function resetVote(): void {
        $this->vote = null;
    }

    
}
