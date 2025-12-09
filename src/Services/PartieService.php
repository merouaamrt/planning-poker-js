<?php

require_once __DIR__ . '/../Models/Joueur.php';
require_once __DIR__ . '/../Models/Fonctionnalite.php';
require_once __DIR__ . '/../Models/Backlog.php';
require_once __DIR__ . '/VoteService.php';

class PartieService {

    private array $joueurs = [];
    private Backlog $backlog;
    private VoteService $voteService;

    public function __construct() {
        $this->backlog = new Backlog(__DIR__ . '/../../data/backlog.json');
        $this->voteService = new VoteService();
    }

    public function ajouterJoueur(string $nom): void {
        $this->joueurs[] = new Joueur($nom);
    }

    public function getJoueurs(): array {
        return $this->joueurs;
    }

    public function getBacklog(): Backlog {
        return $this->backlog;
    }

    public function validerVote(): ?int {
        if ($this->voteService->estUnanime()) {
            return array_values($this->voteService->getVotes())[0];
        }
        return null;
    }
}
