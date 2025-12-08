<?php
require_once __DIR__ . "/../Services/PartieService.php";

class VoteController {
    private $service;

    public function __construct() {
        $this->service = new PartieService();
    }

    public function submit() {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || !isset($body['partieFile']) || !isset($body['playerId']) || !array_key_exists('value', $body)) {
            http_response_code(400);
            echo json_encode(["error"=>"Missing parameters"]);
            return;
        }
        $partie = $this->service->loadFromFile($body['partieFile']);
        if (!$partie) {
            http_response_code(404);
            echo json_encode(["error"=>"Partie not found"]);
            return;
        }
        $pid = $body['playerId'];
        $val = $body['value'];
        $partie->submitVote($pid, $val);
        $this->service->savePartie($partie);

        if ($partie->allVoted()) {
            $result = $this->service->evaluateVotes($partie);
            if ($result['status'] === 'validated') {
                $story = $partie->getCurrentStory();
                if ($story) $story->setEstimation($result['value']);
                $partie->resetVotes();
                $this->service->savePartie($partie);
            } elseif ($result['status'] === 'all_cafe') {
                $this->service->savePartie($partie);
            }
            echo json_encode(["status"=>"all_voted","result"=>$result,"partie"=>$partie->toArray()]);
            return;
        }

        echo json_encode(["status"=>"vote_recorded","partie"=>$partie->toArray()]);
    }
}
