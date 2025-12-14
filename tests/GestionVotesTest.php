<?php

require_once __DIR__ . '/../src/Services/GestionVotes.php';

$g = new GestionVotes();

$g->ajouterVote("Alice", 3);
$g->ajouterVote("Bob", 5);

var_dump($g->estUnanime() === false);
var_dump($g->moyenne() === 4.0);

$g->reset();
var_dump(count($g->getVotes()) === 0);
