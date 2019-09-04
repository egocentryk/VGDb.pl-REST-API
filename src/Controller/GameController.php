<?php

namespace Src\Controller;

use Src\TableGateways\GameGateway;

class GameController {

    private $db;
    private $requestMethod;
    private $gameId;

    private $gameGateway;

    public function __construct($db, $requestMethod, $gameId) {

        $this->db               = $db;
        $this->requestMethod    = $requestMethod;
        $this->gameId           = $gameId;

        $this->gameGateway      = new GameGateway($db);
    }

    public function processRequest() {

        switch($this->requestMethod) {
            case 'GET':

            if ($this->gameId) {
                $response = $this->getGame($this->gameId);
            } else {
                $response = $this->getAllGames();
            };
                break;
        }

        header($response['status_code_header']);
        if($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllGames() {

        // TODO
        echo 'all games';
    }

    private function getGame($id) {

        $result = $this->gameGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result, JSON_PRETTY_PRINT);

        return $response;
    }

    private function notFoundResponse() {

        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}