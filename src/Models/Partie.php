<?php

require_once __DIR__ . '/Backlog.php';
require_once __DIR__ . '/Joueur.php';
require_once __DIR__ . '/../Services/GestionVotes.php';

class Partie {

    private int $id;
    private Backlog $backlog;
    private array $joueurs = [];
    private GestionVotes $votes;
    private int $indexCourant = 0;

    
    
    private string $etat = 'en_attente';


    private ?string $sessionId = null;

    public function __construct(int $id, Backlog $backlog) {
        $this->id = $id;
        $this->backlog = $backlog;
        $this->votes = new GestionVotes();
    }

    public function ajouterJoueur(Joueur $joueur): void {
        $this->joueurs[] = $joueur;
    }

    public function getJoueurs(): array {
        return $this->joueurs;
    }



    public function voter(string $joueur, int $valeur): void {
        $this->votes->ajouterVote($joueur, $valeur);
    }

    public function resultat(): array {
        return [
            'unanimite' => $this->votes->estUnanime(),
            'moyenne'   => $this->votes->moyenne(),
            'mediane'   => $this->votes->mediane()
        ];
    }

    public function passerStorySuivante(): void {
        $this->votes->reset();
        $this->indexCourant++;
    }


    public function demarrer(): void {
        $this->etat = 'en_cours';
    }

    public function mettreEnPause(): void {
        $this->etat = 'en_pause';
    }

    public function terminer(): void {
        $this->etat = 'terminee';
    }

    public function getEtat(): string {
        return $this->etat;
    }

   

    public function setSessionId(string $sessionId): void {
        $this->sessionId = $sessionId;
    }

    public function getSessionId(): ?string {
        return $this->sessionId;
    }
}
