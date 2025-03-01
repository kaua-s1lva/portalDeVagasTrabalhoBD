<?php
// public/index.php

// Exibe erros para facilitar o desenvolvimento (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carrega o autoload do Composer (ajuste o caminho se necessário)
require_once __DIR__ . '/../vendor/autoload.php';

use AwesomePackages\AwesomeRoutes\Router;
use controller\Usuario\UsuarioController;

// Cria uma instância do roteador
$router = new Router();

// Define as rotas desejadas
$router->get('/user', new UsuarioController(), 'index');

// Processa a requisição atual
$router->handleRequest();
