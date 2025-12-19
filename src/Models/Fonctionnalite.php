<?php

class Fonctionnalite {
    public int $id;
    private string $titre;
    private string $description;
    private ?int $estimationFinale = null;
    public string $statut = 'a_estimer';

    public function __construct(int $id, string $titre, string $description = '') {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
    }

       public function setEstimation(int $valeur): void {
        $this->estimationFinale = $valeur;
        $this->statut = 'estimee';
    }

    public function estValidee(): bool {
        return $this->statut === 'validee';
    }

    

    public static function fromArray(array $a): Fonctionnalite {
        $f = new Fonctionnalite(
            (int)($a['id'] ?? 0),
            (string)($a['titre'] ?? ''),
            (string)($a['description'] ?? '')
        );
        $f->estimationFinale = $a['estimationFinale'] ?? null;
        $f->statut = (string)($a['statut'] ?? 'a_estimer');
        return $f;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'estimationFinale' => $this->estimationFinale,
            'statut' => $this->statut,
        ];
    }
}
    
