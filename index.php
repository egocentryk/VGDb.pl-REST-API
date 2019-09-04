<?php

require 'bootstrap.php';

use Src\Controller\GameController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode ('/', $uri);

// all endpoints starts with /game
// if else throw 404 not found
if($uri[1] !== 'game') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// game ID required
$gameId = null;

if(isset($uri[2])) {
    $gameId = (int) $uri[2];
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

$controller = new GameController($dbConnection, $requestMethod, $gameId);
$controller->processRequest();