<?php

namespace App\Controllers;

class TestController  extends BaseController
{
    public function index(): string{
        $db = \Config\Database::connect();
        
        echo "<pre>";
        var_dump($db);
        echo "</pre>";
        //if ($db->connID->connect_error) {
            //die("Connection failed: " . $db->connID->connect_error);
        //}
        
        return "Connected successfully";
    }
}
