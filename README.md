# Planning Poker – Backend

Backend d’une application de planning poker.

## Version 5 – Gestion de l’état d’une partie

Cette version introduit la gestion du cycle de vie d’une partie :

- États possibles : en attente, en cours, en pause, terminée
- Service dédié pour gérer l’état d’une partie
- Service de persistance pour sauvegarder et recharger l’état
- Données stockées en JSON
- Test simple sur les changements d’état

Le projet est structuré selon une architecture MVC progressive.
