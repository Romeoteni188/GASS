<?php

use App\Core\Router;

$router = new Router();

$router->get('/', 'AuthController@login'); // Por ejemplo

$router->dispatch();

