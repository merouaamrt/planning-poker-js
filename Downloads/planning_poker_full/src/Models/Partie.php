<?php
require_once __DIR__ . "/Backlog.php";
require_once __DIR__ . "/Joueur.php";

class Partie {
    public $idPartie;
    public $modeDeJeu = "strict";
    public $statutPartie = "not_started";
    public $listeJoueurs = [];
    public $backlog;
    public $currentIndex = 0;
    public $votes = [];
    public $isPaused = false;
    public $scrumMaster = null;
    public $roundCount = 0;

    public function __construct($id, ?Backlog $backlog = null, $mode = "strict") {
        $this->idPartie = $id;
        $this->backlog = $backlog ?? new Backlog(1);
        $this->modeDeJeu = $mode;
    }

    public function addJoueur(Joueur $j) {
        $this->listeJoueurs[$j->id] = $j;
    }

    public function getCurrentStory() {
        return $this->backlog->listeFonctionnalites[$this->currentIndex] ?? null;
    }

    public function submitVote($playerId, $valeur) {
        $this->votes[$playerId] = $valeur;
    }

    public function resetVotes() {
        $this->votes = [];
        foreach ($this->listeJoueurs as $j) {
            $j->resetVote();
        }
        $this->roundCount++;
    }

    public function allVoted() {
        return count($this->votes) === count($this->listeJoueurs);
    }

    public function incrementIndex() {
        $this->currentIndex++;
        $this->roundCount = 0;
    }

    public function toArray() {
        return [
            "idPartie" => $this->idPartie,
            "modeDeJeu" => $this->modeDeJeu,
            "statutPartie" => $this->statutPartie,
            "listeJoueurs" => array_map(function($j){
                return ["id"=>$j->id,"pseudo"=>$j->pseudo,"estConnecte"=>$j->estConnecte,"carteChoisie"=>$j->carteChoisie];
            }, $this->listeJoueurs),
            "backlog" => $this->backlog->toArray(),
            "currentIndex" => $this->currentIndex,
            "votes" => $this->votes,
            "isPaused" => $this->isPaused,
            "scrumMaster" => $this->scrumMaster,
            "roundCount" => $this->roundCount
        ];
    }

    public static function fromArray($arr) {
        $backlog = Backlog::fromArray($arr['backlog']);
        $p = new Partie($arr['idPartie'] ?? 1, $backlog, $arr['modeDeJeu'] ?? "strict");
        $p->statutPartie = $arr['statutPartie'] ?? "not_started";
        $p->currentIndex = $arr['currentIndex'] ?? 0;
        $p->isPaused = $arr['isPaused'] ?? false;
        $p->scrumMaster = $arr['scrumMaster'] ?? null;
        $p->roundCount = $arr['roundCount'] ?? 0;
        foreach ($arr['listeJoueurs'] as $j) {
            $jou = new Joueur($j['id'],$j['pseudo']);
            $jou->estConnecte = $j['estConnecte'] ?? true;
            $jou->carteChoisie = $j['carteChoisie'] ?? null;
            $p->addJoueur($jou);
        }
        $p->votes = $arr['votes'] ?? [];
        return $p;
    }
}
