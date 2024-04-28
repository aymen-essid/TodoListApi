<?php

namespace App\Controllers;

use App\Service\ApiHandler;
use App\Service\DbConnect;

Abstract Class AbstratcController 
{
    private DbConnect $db;
    private ApiHandler $api;

    public function __construct(DbConnect $db,  ApiHandler $api)
    {
        $this->db = DbConnect::connect();
        $this->api = $api;
    }

    public function save()
    {
        
    }

}