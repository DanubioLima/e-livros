<?php

require __DIR__.'/bootstrap/app.php';

use \App\Http\Router;
use WilliamCosta\DatabaseManager\Database;

//inicia o router
$obRouter = new Router(URL);

//carrega as rotas de páginas
include __DIR__.'/routes/pages.php';


//conexão com o banco de dados
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

//imprime o response da rota
$obRouter->run()->sendResponse();
         


