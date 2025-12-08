<?php
require_once __DIR__ . "/../Services/JsonStorage.php";

class BacklogController {
    private $storage;

    public function __construct() {
        $this->storage = new JsonStorage();
    }

    public function upload() {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || !isset($body['backlog'])) {
            http_response_code(400);
            echo json_encode(["error"=>"Missing backlog"]);
            return;
        }
        $file = $this->storage->saveBacklogArray($body['backlog']);
        echo json_encode(["status"=>"ok","file"=>$file]);
    }

    public function get() {
        $example = json_decode(file_get_contents(__DIR__ . "/../../data/backlog.example.json"), true);
        echo json_encode($example);
    }
}
