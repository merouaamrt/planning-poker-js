<?php

require_once __DIR__ . '/Backlog.php';
require_once __DIR__ . '/Joueur.php';
require_once __DIR__ . '/../Services/GestionVotes.php';

class Partie {

    private int $id;
    private Backlog $backlog;
     /** @var Joueur[] */
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

    public function getId(): int {
        return $this->id;
    }

    public function setSessionId(string $sessionId): void {
        $this->sessionId = $sessionId;
    }

    public function getSessionId(): ?string {
        return $this->sessionId;
    }

    public function ajouterJoueur(Joueur $joueur): void {
        $this->joueurs[] = $joueur;
    }

    public function getJoueurs(): array {
        return $this->joueurs;
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

    public function storyCourante(): ?Fonctionnalite {
        return $this->backlog->getFonctionnalite($this->indexCourant);
    }

    public function voter(string $joueur, int $valeur): void {
        $this->votes->ajouterVote($joueur, $valeur);
    }

    public function resultat(): array {
        return [
            'unanimite' => $this->votes->estUnanime(),
            'moyenne'   => $this->votes->moyenne(),
            'mediane'   => $this->votes->mediane(),
            'votes'     => $this->votes->getVotes(),
        ];
    }

    public function resetVotes(): void {
        $this->votes->reset();
    }

    public function passerStorySuivante(): void {
        $this->votes->reset();
        $this->indexCourant++;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'etat' => $this->etat,
            'sessionId' => $this->sessionId,
            'indexCourant' => $this->indexCourant,
            'joueurs' => array_map(fn($j) => [
                'id' => $j->id,
                'pseudo' => $j->pseudo,
                'vote' => $j->vote,
                'estConnecte' => $j->estConnecte
            ], $this->joueurs),
            'votes' => $this->votes->getVotes(),
            'backlog' => $this->backlog->toArray(),
        ];
    }

    public static function fromArray(array $a): Partie {
        $backlog = Backlog::fromArray($a['backlog'] ?? ['id' => 1, 'fonctionnalites' => []]);
        $p = new Partie((int)($a['id'] ?? 1), $backlog);

        $p->etat = (string)($a['etat'] ?? 'en_attente');
        $p->sessionId = $a['sessionId'] ?? null;
        $p->indexCourant = (int)($a['indexCourant'] ?? 0);

        foreach (($a['joueurs'] ?? []) as $j) {
            $joueur = new Joueur((int)($j['id'] ?? 0), (string)($j['pseudo'] ?? ''));
            $joueur->vote = $j['vote'] ?? null;
            $joueur->estConnecte = (bool)($j['estConnecte'] ?? true);
            $p->joueurs[] = $joueur;
        }

        foreach (($a['votes'] ?? []) as $pseudo => $val) {
            $p->votes->ajouterVote((string)$pseudo, (int)$val);
        }

        return $p;
    }
}