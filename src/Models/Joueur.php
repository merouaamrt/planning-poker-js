<?php

class Joueur {
    private string $pseudo;
    private ?int $vote = null;

    public function __construct(string $pseudo) {
        $this->pseudo = $pseudo;
    }

    public function getPseudo(): string {
        return $this->pseudo;
    }

    public function voter(int $valeur): void {
        $this->vote = $valeur;
    }

    public function resetVote(): void {
        $this->vote = null;
    }

    public function getVote(): ?int {
        return $this->vote;
    }
}
