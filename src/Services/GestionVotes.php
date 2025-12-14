<?php

class GestionVotes {

    private array $votes = [];

    public function ajouterVote(string $joueur, int $valeur): void {
        $this->votes[$joueur] = $valeur;
    }

    public function getVotes(): array {
        return $this->votes;
    }

    public function reset(): void {
        $this->votes = [];
    }

    public function estUnanime(): bool {
        if (count($this->votes) === 0) return false;
        return count(array_unique($this->votes)) === 1;
    }

    public function moyenne(): float {
        if (count($this->votes) === 0) return 0;
        return array_sum($this->votes) / count($this->votes);
    }

    public function mediane(): float {
        if (count($this->votes) === 0) return 0;
        $v = array_values($this->votes);
        sort($v);
        $n = count($v);
        $m = intdiv($n, 2);
        return ($n % 2) ? $v[$m] : ($v[$m - 1] + $v[$m]) / 2;
    }
}

