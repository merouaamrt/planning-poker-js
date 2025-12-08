<?php
require_once __DIR__ . "/../Services/PartieService.php";

class PartieController {
    private $service;

    public function __construct() {
        $this->service = new PartieService();
    }

    public function current() {
        $dir = __DIR__ . "/../../data";
        $files = glob($dir . "/partie_*.json");
        if (empty($files)) {
            echo json_encode(["error"=>"No partie found"]);
            return;
        }
        $file = array_values($files)[count($files)-1];
        $partie = $this->service->loadFromFile($file);
        echo json_encode(["partie"=>$partie->toArray(), "file"=>$file]);
    }

    public function next() {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || !isset($body['partieFile'])) {
            http_response_code(400);
            echo json_encode(["error"=>"Missing partieFile"]);
            return;
        }
        $partie = $this->service->loadFromFile($body['partieFile']);
        if (!$partie) {
            http_response_code(404);
            echo json_encode(["error"=>"Partie not found"]);
            return;
        }
        if (isset($body['validatedValue'])) {
            $story = $partie->getCurrentStory();
            if ($story) $story->setEstimation($body['validatedValue']);
        }
        $partie->incrementIndex();
        $this->service->savePartie($partie);
        echo json_encode(["status"=>"ok","partie"=>$partie->toArray()]);
    }

    public function save() {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || !isset($body['partieFile'])) {
            http_response_code(400);
            echo json_encode(["error"=>"Missing partieFile"]);
            return;
        }
        $partie = $this->service->loadFromFile($body['partieFile']);
        if (!$partie) {
            http_response_code(404);
            echo json_encode(["error"=>"Partie not found"]);
            return;
        }
        $file = $this->service->savePartie($partie);
        echo json_encode(["status"=>"saved","file"=>$file]);
    }

    public function load() {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || !isset($body['file'])) {
            http_response_code(400);
            echo json_encode(["error"=>"Missing file"]);
            return;
        }
        $partie = $this->service->loadFromFile($body['file']);
        if (!$partie) {
            http_response_code(404);
            echo json_encode(["error"=>"Not found"]);
            return;
        }
        echo json_encode(["partie"=>$partie->toArray()]);
    }
}
