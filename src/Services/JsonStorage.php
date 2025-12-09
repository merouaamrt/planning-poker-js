<?php
class JsonStorage {
    private $dir;

    public function __construct($dir = null) {
        $this->dir = $dir ?? __DIR__ . "/../../data";
        if (!file_exists($this->dir)) mkdir($this->dir, 0777, true);
    }

    public function savePartie(Partie $p, $filename = null) {
        $filename = $filename ?? sprintf("%s/partie_%s.json", $this->dir, $p->idPartie);
        file_put_contents($filename, json_encode($p->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $filename;
    }

    public function loadPartie($filepath) {
        if (!file_exists($filepath)) return null;
        $content = json_decode(file_get_contents($filepath), true);
        return Partie::fromArray($content);
    }

    public function saveBacklogArray(array $arr, $filename = null) {
        $filename = $filename ?? sprintf("%s/backlog_%s.json", $this->dir, time());
        file_put_contents($filename, json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $filename;
    }
}
