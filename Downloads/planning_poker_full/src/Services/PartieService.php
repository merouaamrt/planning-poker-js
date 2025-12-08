<?php
require_once __DIR__ . "/JsonStorage.php";
require_once __DIR__ . "/VoteService.php";

class PartieService {
    private $storage;
    private $voteService;
    private $currentPartieFile;

    public function __construct() {
        $this->storage = new JsonStorage();
        $this->voteService = new VoteService();
    }

    public function createFromBacklogArray(array $backlogArr, $mode = "strict", $scrumMaster = null) {
        $backlog = Backlog::fromArray($backlogArr);
        $partie = new Partie(rand(1000,9999), $backlog, $mode);
        $partie->statutPartie = "created";
        $partie->scrumMaster = $scrumMaster;
        $this->currentPartieFile = $this->storage->savePartie($partie, null);
        return $partie;
    }

    public function savePartie(Partie $p) {
        return $this->storage->savePartie($p);
    }

    public function loadFromFile($filepath) {
        return $this->storage->loadPartie($filepath);
    }

    public function evaluateVotes(Partie $p) {
        return $this->voteService->evaluate($p);
    }
}
