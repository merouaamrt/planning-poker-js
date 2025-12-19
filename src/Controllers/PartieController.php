<?php

require_once __DIR__ . '/../Models/Backlog.php';
require_once __DIR__ . '/../Models/Partie.php';
require_once __DIR__ . '/../Models/Joueur.php';
require_once __DIR__ . '/../Services/SessionPersistenceService.php';

class PartieController {

    private SessionPersistenceService $sessions;

    public function __construct() {
        $this->sessions = new SessionPersistenceService(__DIR__ . '/../../data/sessions');
    }

    private function loadSessionOrFail(): ?Session {
        $sessionId = $_REQUEST['session_id'] ?? null;
        if (!$sessionId) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'session_id manquant']);
            return null;
        }
        $session = $this->sessions->load($sessionId);
        if (!$session) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'session introuvable']);
            return null;
        }
        return $session;
    }

    public function creer(): void {
        $session = $this->loadSessionOrFail();
        if (!$session) return;

        $backlog = new Backlog(1, __DIR__ . '/../../data/backlog.json');
        $backlog->chargerDepuisJson();

        $partieId = (int)($_POST['partie_id'] ?? 1);
        $partie = new Partie($partieId, $backlog);
        $partie->setSessionId($session->getId());

        $session->ajouterPartie($partie);
        $this->sessions->save($session);

        echo json_encode(['status' => 'ok', 'partie' => $partie->toArray()]);
    }

    public function ajouterJoueur(): void {
        $session = $this->loadSessionOrFail();
        if (!$session) return;

        $partieId = (int)($_POST['partie_id'] ?? 0);
        $pseudo = $_POST['pseudo'] ?? null;

        if (!$partieId || !$pseudo) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'partie_id / pseudo manquant']);
            return;
        }

        $partie = $session->getPartie($partieId);
        if (!$partie) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'partie introuvable']);
            return;
        }

        $newId = count($partie->getJoueurs()) + 1;
        $partie->ajouterJoueur(new Joueur($newId, $pseudo));

        $this->sessions->save($session);
        echo json_encode(['status' => 'ok', 'partie' => $partie->toArray()]);
    }

    public function etat(): void {
        $session = $this->loadSessionOrFail();
        if (!$session) return;

        $partieId = (int)($_GET['partie_id'] ?? 0);
        $partie = $session->getPartie($partieId);

        if (!$partie) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'partie introuvable']);
            return;
        }

        echo json_encode(['status' => 'ok', 'etat' => $partie->getEtat()]);
    }

    public function demarrer(): void {
        $this->setEtatAction('start');
    }

    public function pause(): void {
        $this->setEtatAction('pause');
    }

    public function terminer(): void {
        $this->setEtatAction('end');
    }

    private function setEtatAction(string $mode): void {
        $session = $this->loadSessionOrFail();
        if (!$session) return;

        $partieId = (int)($_POST['partie_id'] ?? 0);
        $partie = $session->getPartie($partieId);

        if (!$partie) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'partie introuvable']);
            return;
        }

        if ($mode === 'start') $partie->demarrer();
        if ($mode === 'pause') $partie->mettreEnPause();
        if ($mode === 'end')   $partie->terminer();

        $this->sessions->save($session);
        echo json_encode(['status' => 'ok', 'etat' => $partie->getEtat()]);
    }

    public function storyCourante(): void {
        $session = $this->loadSessionOrFail();
        if (!$session) return;

        $partieId = (int)($_GET['partie_id'] ?? 0);
        $partie = $session->getPartie($partieId);

        if (!$partie) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'partie introuvable']);
            return;
        }

        $story = $partie->storyCourante();
        echo json_encode([
            'status' => 'ok',
            'story' => $story ? $story->toArray() : null
        ]);
    }

    public function nextStory(): void {
        $session = $this->loadSessionOrFail();
        if (!$session) return;

        $partieId = (int)($_POST['partie_id'] ?? 0);
        $partie = $session->getPartie($partieId);

        if (!$partie) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'partie introuvable']);
            return;
        }

        $partie->passerStorySuivante();
        $this->sessions->save($session);

        echo json_encode(['status' => 'ok', 'partie' => $partie->toArray()]);
    }
}









   