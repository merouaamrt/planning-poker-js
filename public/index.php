<?php
/**
 * Point d'entrée unique (MAMP / Apache) :
 * - Sans paramètre `action` => redirige vers le frontend
 * - Avec `action` => mini API JSON (pratique pour tests)
 *
 * IMPORTANT : le frontend de ce projet utilise principalement /public/app/api/*.php
 */

$action = $_GET['action'] ?? '';

// Base URL (ex: /mea/public)
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$base = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

// 1) FRONTEND
if ($action === '') {
    header('Location: ' . $base . '/app/index.html');
    exit;
}

// 2) API JSON
header('Content-Type: application/json; charset=utf-8');

function json_response(int $code, array $payload): void {
    http_response_code($code);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function sid_is_valid(string $sid): bool {
    return (bool)preg_match('/^[a-zA-Z0-9_-]{6,40}$/', $sid);
}

function data_dir_public_app(): string {
    $dir = __DIR__ . '/app/data';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    return $dir;
}

try {
    switch ($action) {
        // --- Mini endpoints de test ---
        case 'session.create': {
            $sid = bin2hex(random_bytes(8));
            json_response(200, ['ok' => true, 'sid' => $sid]);
        }

        case 'session.get': {
            $sid = $_GET['sid'] ?? '';
            if (!$sid || !sid_is_valid($sid)) {
                json_response(400, ['ok' => false, 'error' => 'sid invalide']);
            }
            $path = data_dir_public_app() . "/config_{$sid}.json";
            if (!file_exists($path)) {
                json_response(404, ['ok' => false, 'error' => 'Session/config introuvable']);
            }
            $cfg = json_decode((string)file_get_contents($path), true);
            if (!is_array($cfg)) {
                json_response(500, ['ok' => false, 'error' => 'Config corrompue']);
            }
            json_response(200, ['ok' => true, 'config' => $cfg]);
        }

        default:
            json_response(404, [
                'ok' => false,
                'error' => 'Action inconnue',
                'hint' => 'Le front utilise /public/app/api/*.php (ex: /public/app/api/config_save.php)'
            ]);
    }
} catch (Throwable $e) {
    json_response(500, ['ok' => false, 'error' => $e->getMessage()]);
}
