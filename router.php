<?php
session_start();
if (php_sapi_name() === 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require_once __DIR__ . '/vendor/autoload.php';

use app\controller\aluno\AlunoController;
use app\controller\candidatura\CandidaturaController;
use app\controller\usuario\UsuarioController;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Router;

$request = new Request($_POST, isset($_GET['id']) ? (int)$_GET['id'] : null);

$router = new Router();

// Defina suas rotas
$router->get('/', new UsuarioController(), 'renderHome');
$router->get('/usuario/novo', new UsuarioController(), 'renderCreate');

$router->post('/usuario/novo', new UsuarioController(), 'create');
$router->post('/usuario/login', new UsuarioController(), 'login');

$router->get('/usuario/logout', new UsuarioController(), 'logout');

$router->get('/aluno', new AlunoController(), 'index');
$router->get('/aluno/visualizar', new AlunoController(), 'show');

$router->post('/aluno/candidatar', new CandidaturaController(), 'create');

// Processa a requisição
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
