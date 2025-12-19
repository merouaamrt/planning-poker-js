<?php

class PartieStateService {

    private string $etat = 'en_attente';

    public function demarrer(): void {
        $this->etat = 'en_cours';
    }

    public function mettreEnPause(): void {
        $this->etat = 'en_pause';
    }

    public function terminer(): void {
        $this->etat = 'terminee';
    }

    public function getEtat(): string {
        return $this->etat;
    }

    public function estEnCours(): bool {
        return $this->etat === 'en_cours';
    }
}
