<?php

namespace Src\TableGateways;

class GameGateway {

    private $db = null;

    public function __construct($db) {
        
        $this->db = $db;
    }

    public function find($id) {

        $stmt = $this->db->prepare('
            SELECT 
                a.*
            FROM 
                '.getenv('DB_TABLE_PREFIX').'_games a 
            WHERE 
                a.id = ?
        ');

        try {
            $stmt->execute(array($id));
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}