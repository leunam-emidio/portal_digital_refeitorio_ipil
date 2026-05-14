<?php

    session_start();
    require_once __DIR__ . '/../../vendor/autoload.php';
    

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    

    try{
        $conn = new PDO(
        "mysql:host=".$_ENV['DB_host'].";dbname=".$_ENV['DB_name'],
        $_ENV['DB_user'],
        $_ENV['DB_pass']);

    }catch(PDOException $e){
        echo "Erro: ".$e->getMessage();
    }
?>