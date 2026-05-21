<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/../vendor/autoload.php';
    

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    

    try{
        $conn = new PDO(
        "mysql:host=".$_ENV['DB_host'].";dbname=".$_ENV['DB_name'],
        $_ENV['DB_user'],
        $_ENV['DB_pass']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Erro: ".$e->getMessage();
    }


?>