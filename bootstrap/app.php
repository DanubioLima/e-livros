<?php

require __DIR__.'/../vendor/autoload.php';

use \App\Utils\View;
use WilliamCosta\DotEnv\Environment;

//carrega as variáveis de ambiente
Environment::load(__DIR__.'/../');

//define a url padrão
define('URL', getenv('URL'));

//carrega a url
View::init([
    'URL' => URL
]);
