<?php
require_once __DIR__ . "/../Models/GestionVotes.php";

class VoteService {

    public function evaluate(Partie $partie) {
        $votes = array_values($partie->votes);
        if (GestionVotes::allCafe($votes)) {
            $partie->isPaused = true;
            return ["status" => "all_cafe"];
        }

        if ($partie->modeDeJeu === "strict" || $partie->roundCount === 0) {
            if (GestionVotes::isUnanimous($votes)) {
                $val = current(array_filter($votes, function($v){ return $v !== 'cafe'; }));
                return ["status" => "validated", "value" => $val];
            } else {
                return ["status" => "revote"];
            }
        }

        switch ($partie->modeDeJeu) {
            case "moyenne":
                $m = GestionVotes::moyenne($votes);
                return ["status" => "validated", "value" => round($m)];
            case "mediane":
                $m = GestionVotes::mediane($votes);
                return ["status" => "validated", "value" => round($m)];
            case "maj_abs":
                $m = GestionVotes::majoriteAbsolue($votes);
                if ($m !== null) return ["status" => "validated", "value" => $m];
                return ["status" => "revote"];
            case "maj_rel":
                $m = GestionVotes::majoriteRelative($votes);
                return ["status" => "validated", "value" => $m];
            default:
                return ["status" => "error", "message" => "Unknown mode"];
        }
    }
}
