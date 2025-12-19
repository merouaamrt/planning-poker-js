<?php

require_once __DIR__ . '/../src/Services/SessionService.php';

$service = new SessionService();
$session = $service->creerSession();

var_dump(!empty($session->getId()));
