<?php

namespace controller\Usuario;
use AwesomePackages\AwesomeRoutes\Core\Controller;
use Exception;

class UsuarioController extends Controller
{
    public function renderSignup() {
        echo "Olá mundo";
    }

    
    function view(string $viewPath, array $data = [])
    {
        // Extrai os dados para criar variáveis com os nomes dos índices do array
        extract($data);
        // Define o caminho base para as views (ajuste conforme sua estrutura)
        $fullPath = __DIR__ . '/../views/' . $viewPath . '.php';
        
        if (file_exists($fullPath)) {
            // Inicia o buffer para capturar o conteúdo da view
            ob_start();
            include $fullPath;
            // Retorna o conteúdo renderizado
            return ob_get_clean();
        }
        
        throw new Exception("View não encontrada: " . $fullPath);
    }

}