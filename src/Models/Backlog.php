<?php

require_once __DIR__ . '/Fonctionnalite.php';
require_once __DIR__ . '/../Services/JsonStorage.php';

class Backlog {
    public int $id;
    /** @var Fonctionnalite[] */
    public array $listeFonctionnalites = [];

    private ?JsonStorage $storage = null;

    public function __construct(int $id = 1, ?string $jsonPath = null) {
        $this->id = $id;
        if ($jsonPath) {
            $this->storage = new JsonStorage($jsonPath);
        }
    }

    public function chargerDepuisJson(): void {
        if (!$this->storage) return;

        $data = $this->storage->load();
        $this->id = (int)($data['id'] ?? $this->id);

        $this->listeFonctionnalites = [];
        foreach (($data['fonctionnalites'] ?? []) as $f) {
            $this->listeFonctionnalites[] = Fonctionnalite::fromArray($f);
        }
    }

    public function sauvegarderVersJson(): void {
        if (!$this->storage) return;

        $payload = [
            'id' => $this->id,
            'fonctionnalites' => array_map(fn($f) => $f->toArray(), $this->listeFonctionnalites),
        ];
        $this->storage->save($payload);
    }

    public function getFonctionnalite(int $index): ?Fonctionnalite {
        return $this->listeFonctionnalites[$index] ?? null;
    }

    public function count(): int {
        return count($this->listeFonctionnalites);
    }

    public static function fromArray(array $a): Backlog {
        $b = new Backlog((int)($a['id'] ?? 1), null);
        foreach (($a['fonctionnalites'] ?? []) as $f) {
            $b->listeFonctionnalites[] = Fonctionnalite::fromArray($f);
        }
        return $b;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'fonctionnalites' => array_map(fn($f) => $f->toArray(), $this->listeFonctionnalites),
        ];
    }
}
