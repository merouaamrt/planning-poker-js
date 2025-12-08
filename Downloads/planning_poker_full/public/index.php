<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../src/Models/Carte.php";
require_once __DIR__ . "/../src/Models/Fonctionnalite.php";
require_once __DIR__ . "/../src/Models/Joueur.php";
require_once __DIR__ . "/../src/Models/Backlog.php";
require_once __DIR__ . "/../src/Models/Partie.php";
require_once __DIR__ . "/../src/Models/GestionVotes.php";

require_once __DIR__ . "/../src/Services/JsonStorage.php";
require_once __DIR__ . "/../src/Services/VoteService.php";
require_once __DIR__ . "/../src/Services/PartieService.php";

require_once __DIR__ . "/../src/Controllers/SessionController.php";
require_once __DIR__ . "/../src/Controllers/PartieController.php";
require_once __DIR__ . "/../src/Controllers/VoteController.php";
require_once __DIR__ . "/../src/Controllers/BacklogController.php";

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$uri = '/' . trim(substr($path, strlen($base)), '/');

if ($uri === '/' || $uri === '/index.php') {
    echo json_encode(["message" => "Backend API OK", "available_endpoints" => [
        "POST /api/session/create",
        "POST /api/session/join",
        "GET /api/partie/current",
        "POST /api/vote/submit",
        "POST /api/backlog/upload",
        "POST /api/partie/next",
        "POST /api/partie/save",
        "POST /api/partie/load"
    ]]);
    exit;
}

$parts = explode('/', trim($uri, '/'));
if ($parts[0] !== 'api') {
    http_response_code(404);
    echo json_encode(["error" => "Only /api endpoints are supported"]);
    exit;
}

$resource = $parts[1] ?? null;
$action = $parts[2] ?? null;

switch ("$resource/$action") {
    case 'session/create':
        (new SessionController())->create();
        break;

    case 'session/join':
        (new SessionController())->join();
        break;

    case 'partie/current':
        (new PartieController())->current();
        break;

    case 'partie/next':
        (new PartieController())->next();
        break;

    case 'partie/save':
        (new PartieController())->save();
        break;

    case 'partie/load':
        (new PartieController())->load();
        break;

    case 'backlog/upload':
        (new BacklogController())->upload();
        break;

    case 'backlog/get':
        (new BacklogController())->get();
        break;

    case 'vote/submit':
        (new VoteController())->submit();
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Unknown endpoint: $resource/$action"]);
        break;
}
