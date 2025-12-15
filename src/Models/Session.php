<?php

class Session {

    private string $id;
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
}
