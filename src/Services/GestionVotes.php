<?php

class GestionVotes {

    /** @var array<string,int> pseudo => valeur */
    private array $votes = [];

    public function ajouterVote(string $pseudo, int $valeur): void {
        $this->votes[$pseudo] = $valeur;
    }

    public function getVotes(): array {
        return $this->votes;
    }

    public function reset(): void {
        $this->votes = [];
    }

    public function estUnanime(): bool {
        if (count($this->votes) === 0) return false;
        $values = array_values($this->votes);
        return count(array_unique($values)) === 1;
    }

    public function moyenne(): float {
        if (count($this->votes) === 0) return 0.0;
        return array_sum($this->votes) / count($this->votes);
    }

    public function mediane(): float {
        if (count($this->votes) === 0) return 0.0;
        $values = array_values($this->votes);
        sort($values);
        $n = count($values);
        $mid = intdiv($n, 2);
        if ($n % 2 === 1) return (float)$values[$mid];
        return ((float)$values[$mid - 1] + (float)$values[$mid]) / 2.0;
    }
}

