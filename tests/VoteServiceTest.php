<?php

require_once __DIR__ . '/../src/Services/VoteService.php';

$service = new VoteService();


$service->resetVotes();


$service->ajouterVote("Alice", 3);
$service->ajouterVote("Bob", 5);


$votes = $service->getVotes();

echo "Votes enregistrés :\n";
var_dump($votes);


echo "Nombre de votes = 2 : ";
var_dump(count($votes) === 2);


$service->resetVotes();
echo "Votes après reset = 0 : ";
var_dump(count($service->getVotes()) === 0);
