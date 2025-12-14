<?php

require_once __DIR__ . '/Fonctionnalite.php';

class Backlog {
    private array $fonctionnalites = [];

    public function ajouterFonctionnalite(Fonctionnalite $f): void {
        $this->fonctionnalites[] = $f;
    }

    public function getFonctionnalite(int $index): ?Fonctionnalite {
        return $this->fonctionnalites[$index] ?? null;
    }

    public function getToutes(): array {
        return $this->fonctionnalites;
    }
}
