<?php

namespace App\Service;

use PDO;
use PDOException;

class DbHandler extends PDO
{

    private const USER = DB_USERNAME;
    private const PASSWD = DB_PASSWORD;
    private const SERVER = DB_SERVER;
    private const SERVER_PORT = DB_SERVER_PORT;
    private const DB_NAME = DB_NAME;

    private $connexion;

    public function __construct()
    {
        $this->connexion = $this->connect();
    }

    public function connect(): PDO
    {

        $dsn = 'mysql:host=' .self::SERVER. ';port=' . self::SERVER_PORT . ';dbname=' . self::DB_NAME ;
        
        try {
            $connexion = new PDO($dsn, self::USER, self::PASSWD, [PDO::ATTR_PERSISTENT => true]);
        } catch (PDOException $e) {
            printf("Échec de la connexion : %s\n", $e->getMessage());
            exit();
        }

        return $connexion;
    }

}
