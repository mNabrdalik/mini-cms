<?php

    require_once __DIR__ . '/../vendor/autoload.php'; // jeśli masz composera
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $servername = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];


    use MiniCMS\Database\Database;

    // create singleton instance
    $db = MiniCMS\Database\Database::getInstance($servername, $dbname, $username, $password);


    $connection = $db->getConnection();

    //post sql
    // $stmt = $connection->query("SELECT * FROM posts");
    // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($results);
?>