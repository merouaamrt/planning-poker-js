<?php

require_once __DIR__ . '/../Services/JsonStorage.php';
require_once __DIR__ . '/Fonctionnalite.php';

class Backlog {
    private array $taches = [];
    private JsonStorage $storage;

    public function __construct(string $fichier) {
        $this->storage = new JsonStorage($fichier);
        $this->charger();
    }

    public function ajouter(Fonctionnalite $f): void {
        $this->taches[] = $f;
        $this->sauvegarder();
    }

    public function getTaches(): array {
        return $this->taches;
    }

    public function sauvegarder(): void {
        $this->storage->save($this->taches);
    }

    public function charger(): void {
        $donnees = $this->storage->load();
        foreach ($donnees as $t) {
            $this->taches[] = new Fonctionnalite($t['nom']);
        }
    }
}
