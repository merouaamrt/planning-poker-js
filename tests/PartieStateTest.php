<?php

require_once __DIR__ . '/../src/Models/Partie.php';
require_once __DIR__ . '/../src/Models/Backlog.php';

$backlog = new Backlog(1);
$partie = new Partie(1, $backlog);

$partie->demarrer();
var_dump($partie->getEtat() === 'en_cours');

$partie->mettreEnPause();
var_dump($partie->getEtat() === 'en_pause');

$partie->terminer();
var_dump($partie->getEtat() === 'terminee');
