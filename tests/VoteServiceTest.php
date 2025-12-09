<?php

require_once __DIR__ . '/../src/Services/VoteService.php';

$service = new VoteService();
$service->resetVotes();

$service->ajouterVote("Alice", 3);
$service->ajouterVote("Bob", 3);

echo "Unanimité attendue : ";
var_dump($service->estUnanime() === true);

$service->resetVotes();

$service->ajouterVote("meroua", 3);
$service->ajouterVote("aya", 5);

echo "Pas unanimité attendue : ";
var_dump($service->estUnanime() === false);
