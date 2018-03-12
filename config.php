<?php

require 'environment.php';

$config = array();

if(ENVIRONMENT =="devolpment"){
    define("BASE_URL", "http://localhost/copabud/");
    $config['dbname'] = "copabud";
    $config['host'] = "localhost";
    $config['dbuser'] = "root";
    $config['dbpass'] = "";
}
else{
    define("BASE_URL", "http://localhost/copabud/");
    $config['dbname'] = "copabud";
    $config['host'] = "localhost";
    $config['dbuser'] = "root";
    $config['dbpass'] = "";
}

try{
    $db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'],$config['dbuser'],$config['dbpass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro:'.$e->getMessage();
}
