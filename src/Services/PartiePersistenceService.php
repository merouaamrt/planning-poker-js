<?php

require_once __DIR__ . '/JsonStorage.php';

class PartiePersistenceService {

    private JsonStorage $storage;

    public function __construct() {
        $this->storage = new JsonStorage(__DIR__ . '/../../data/partie.json');
    }

    public function sauvegarder(array $etat): void {
        $this->storage->save($etat);
    }

    public function charger(): array {
        return $this->storage->load();
    }
}
