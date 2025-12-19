# Planning Poker — Projet complet (Frontend + Backend)

Ce ZIP regroupe :
- **Backend PHP** (repo GitHub `planning-poker-js`) : dossier `src/`, `data/`, `public/index.php`, etc.
- **Frontend** (ton `projet.zip`) : copié dans `public/app/`.

## Lancer en local

Prérequis : **PHP 8+**.

Depuis la racine du projet :

```bash
php -S localhost:8000 -t public
```

Puis ouvre :
- Frontend : `http://localhost:8000/` (redirige vers `/app/index.html`)
- Backend API (si tu l'utilises) : `http://localhost:8000/index.php?action=session.create` (exemples dans `public/index.php`)

> Note : le frontend utilise ses endpoints PHP internes (dans `public/app/api/`).
> Le backend MVC reste en place tel que commité, prêt à être branché/complété ensuite.

---

# Planning Poker – Backend PHP

Backend d’une application de planning poker développé en PHP
sans framework, avec une architecture MVC progressive.

## Fonctionnalités principales
- Gestion des parties de planning poker
- Gestion des joueurs et des votes
- Calcul des résultats (unanimité, moyenne, médiane)
- Gestion de l’état d’une partie (attente, en cours, pause, terminée)
- Gestion des sessions de jeu
- Stockage simple des données en JSON

## Architecture
- Models : logique métier
- Services : règles et traitements
- Controllers : points d’entrée applicatifs
- Tests unitaires simples pour les services principaux


