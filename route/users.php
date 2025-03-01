<?php 
use \AwesomePackages\AwesomeRoutes\Router;
use \controller\Usuario\UsuarioController;

$router = new Router();

$router->get('/user', new UsuarioController(), 'index');

$router->handleRequest();