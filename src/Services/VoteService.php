<?php

require_once __DIR__ . '/JsonStorage.php';

class VoteService {

    private JsonStorage $storage;

    public function __construct() {
        $this->storage = new JsonStorage(__DIR__ . '/../../data/votes.json');
    }

    public function resetVotes(): void {
        $this->storage->save([]);
    }

    public function ajouterVote(string $joueur, int $valeur): void {
        $votes = $this->storage->load();
        $votes[$joueur] = $valeur;
        $this->storage->save($votes);
    }

    public function getVotes(): array {
        return $this->storage->load();
    }

    public function estUnanime(): bool {
        $votes = $this->getVotes();
        return count(array_unique($votes)) <= 1;
    }
}

