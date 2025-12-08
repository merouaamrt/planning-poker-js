<?php
require_once __DIR__ . "/../Services/JsonStorage.php";
require_once __DIR__ . "/Fonctionnalite.php";

class Backlog {
    public $id;
    public $listeFonctionnalites = [];

    public function __construct($id = 1) {
        $this->id = $id;
    }

    public static function fromArray(array $arr) {
        $b = new Backlog($arr['id'] ?? 1);
        foreach ($arr['fonctionnalites'] as $f) {
            $func = new Fonctionnalite($f['id'], $f['titre'], $f['description'] ?? "");
            if (isset($f['estimationFinale'])) {
                $func->estimationFinale = $f['estimationFinale'];
                $func->statut = $f['statut'] ?? "validated";
            }
            $b->listeFonctionnalites[] = $func;
        }
        return $b;
    }

    public function toArray() {
        $out = [
            "id" => $this->id,
            "fonctionnalites" => []
        ];
        foreach ($this->listeFonctionnalites as $f) {
            $out['fonctionnalites'][] = [
                "id" => $f->id,
                "titre" => $f->titre,
                "description" => $f->description,
                "estimationFinale" => $f->estimationFinale,
                "statut" => $f->statut
            ];
        }
        return $out;
    }
}
