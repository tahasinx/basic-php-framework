<?php
// --- Load environment variables and core dependencies ---
require_once 'env.php';
load_env();
require_once 'database.php';
require_once 'helpers.php';
require_once 'Router.php';

// --- Initialize Router ---
$router = new Router();
require_once 'routes/web.php';

// --- Get HTTP method and URI ---
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// --- Base Path Auto-Detection ---
// Get the directory where index.php is located, relative to the document root
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$scriptDir = rtrim(dirname($scriptName), '/');

// Remove the base path from the URI if present
if ($scriptDir !== '' && $scriptDir !== '/') {
    if (strpos($uri, $scriptDir) === 0) {
        $uri = substr($uri, strlen($scriptDir));
        if ($uri === '' || $uri[0] !== '/') $uri = '/' . $uri;
    }
}

// --- Dispatch the request to the router ---
$router->dispatch($method, $uri);
