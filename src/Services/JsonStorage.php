<?php

class JsonStorage {

    private string $fichier;

    public function __construct(string $fichier) {
        $this->fichier = $fichier;

        if (!file_exists($fichier)) {
            file_put_contents($fichier, json_encode([]));
        }
    }

    public function save(array $data): void {
        file_put_contents($this->fichier, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function load(): array {
        return json_decode(file_get_contents($this->fichier), true) ?? [];
    }
}
