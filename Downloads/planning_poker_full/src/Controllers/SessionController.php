<?php
require_once __DIR__ . "/../Services/PartieService.php";

class SessionController {
    private $service;

    public function __construct() {
        $this->service = new PartieService();
    }

    public function create() {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || !isset($body['backlog'])) {
            http_response_code(400);
            echo json_encode(["error"=>"Missing backlog in request body"]);
            return;
        }
        $mode = $body['mode'] ?? "strict";
        $scrumMaster = $body['scrumMaster'] ?? null;
        $partie = $this->service->createFromBacklogArray($body['backlog'], $mode, $scrumMaster);
        echo json_encode(["status"=>"created","partie"=>$partie->toArray()]);
    }

    public function join() {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || !isset($body['partieFile']) || !isset($body['pseudo'])) {
            http_response_code(400);
            echo json_encode(["error"=>"Missing partieFile or pseudo"]);
            return;
        }
        $partie = $this->service->loadFromFile($body['partieFile']);
        if (!$partie) {
            http_response_code(404);
            echo json_encode(["error"=>"Partie file not found"]);
            return;
        }
        $id = count($partie->listeJoueurs) + 1;
        $jou = new Joueur($id, $body['pseudo']);
        $partie->addJoueur($jou);
        $this->service->savePartie($partie);
        echo json_encode(["status"=>"joined","partie"=>$partie->toArray()]);
    }
}
