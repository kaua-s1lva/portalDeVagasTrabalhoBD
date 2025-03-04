<?php
// Se for um arquivo existente (CSS, JS, imagens, etc.), deixa o PHP servir normalmente
if (php_sapi_name() === 'cli-server') {
    $filePath = __DIR__ . '/' . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    if (is_file($filePath)) {
        return false;
    }
}

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use app\controller\usuario\UsuarioController;
use app\controller\empresa\EmpresaController;
use AwesomePackages\AwesomeRoutes\Core\Request;
use AwesomePackages\AwesomeRoutes\Router;

$request = new Request($_POST, isset($_GET['id']) ? (int)$_GET['id'] : null);

$router = new Router();

// Defina suas rotas
$router->get('/', new UsuarioController(), 'renderHome');
$router->get('/usuario/novo', new UsuarioController(), 'renderCreate');

$router->post('/usuario/novo', new UsuarioController(), 'create');
$router->post('/usuario/login', new UsuarioController(), 'login');

// ROTAS DE EMPRESA
$router->get('/empresa/vagas', new EmpresaController(), 'renderCreateVagas');
$router->get('/empresa/perfil', new EmpresaController(), 'renderCreatePerfilEmpresa');
$router->get('/empresa/egressos', new EmpresaController(), 'renderCreateEgressos');
$router->post('/empresa/atualizarempresa', new EmpresaController(), 'atualizarEmpresa');
$router->post('/empresa/criaregresso', new EmpresaController(), 'criarEgresso');
$router->get('/empresa/editaregresso/:id', new EmpresaController(), 'renderCreateEditarEgresso');
$router->post('/empresa/editaregresso', new EmpresaController(), 'editarEgresso');
$router->get('/empresa/removeregresso/:id', new EmpresaController(), 'removerEgresso');

// ROTAS DE VAGA DA EMPRESA

$router->get('/empresa/rendervaga/:id', new EmpresaController(), 'renderVaga');
$router->post('/empresa/criarvaga', new EmpresaController(), 'criarVaga');
$router->post('/empresa/editarvaga', new EmpresaController(), 'editarVaga');
$router->get('/empresa/removervaga/:id', new EmpresaController(), 'removerVaga');

// Processa a requisição
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
