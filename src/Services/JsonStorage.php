<?php

class JsonStorage {
    private string $path;

    public function __construct(string $path) {
        $this->path = $path;
    }

    public function load(): array {
        if (!file_exists($this->path)) {
            return [];
        }
        $raw = file_get_contents($this->path);
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    public function save(array $data): void {
        $dir = dirname($this->path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($this->path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

