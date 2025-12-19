<?php

class Session {

    private string $id;
        /** @var Partie[] */

    private array $parties = [];

    public function __construct(string $id) {
        $this->id = $id;
    }

    public function getId(): string {
        return $this->id;
    }

    public function ajouterPartie(Partie $partie): void {
        $this->parties[] = $partie;
    }

    public function getParties(): array {
        return $this->parties;
    }

    public function getPartie(int $partieId): ?Partie {
        foreach ($this->parties as $p) {
            if ($p->getId() === $partieId) return $p;
        }
        return null;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'parties' => array_map(fn($p) => $p->toArray(), $this->parties),
        ];
    }

    public static function fromArray(array $a): Session {
        $s = new Session((string)($a['id'] ?? ''));
        foreach (($a['parties'] ?? []) as $pArr) {
            $s->parties[] = Partie::fromArray($pArr);
        }
        return $s;
    }
}

