<?php

    require_once __DIR__ . '/../vendor/autoload.php'; // jeśli masz composera
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $servername = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];


    use MiniCMS\Database\Database;
    use MiniCMS\Routing\Router;

    // create singleton instance
    $db = MiniCMS\Database\Database::getInstance($servername, $dbname, $username, $password);


    $connection = $db->getConnection();

    //post sql
    // $stmt = $connection->query("SELECT * FROM posts");
    // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($results);

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //URL typed by user.
    $router = new Router($path);
    
    $router->get("/", function() {
        require __DIR__ . '/views/home.php';
    });

    $router->group('/admin', function($router) {
        $router->get('/dashboard', function() {
            echo "Admin panel";
        });

        $router->get('/users', function() {
            echo "Lista użytkowników";
        });
    });

    $router->get('/posts/{id}', function($id) {
        echo "Wyświetlam post o ID: $id";
    });

    $router->dispatch();


?>