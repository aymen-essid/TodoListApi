<?php

namespace App\Controllers;

interface InterfaceController
{

    // public function db();

    // public function api($url);

    public function render(string $tplFile);

    public function jsonHttpResponse($httpCode, $data) : void;

}