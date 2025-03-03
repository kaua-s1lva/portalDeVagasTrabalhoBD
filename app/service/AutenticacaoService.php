<?php
namespace app\service;
use app\chain\AutenticadorAluno;
use app\chain\AutenticadorEgresso;
use app\chain\AutenticadorEmpresa;

class AutenticacaoService
{
    private $autenticadores = [];

    public function __construct()
    {
        $this->autenticadores[] = new AutenticadorAluno();
        $this->autenticadores[] = new AutenticadorEgresso();
        $this->autenticadores[] = new AutenticadorEmpresa();
    }

    public function autenticar($username, $password)
    {
        foreach ($this->autenticadores as $autenticador) {
            $usuario = $autenticador->autenticar($username, $password);

            if ($usuario) {
                // Salva o tipo de usuário na sessão
                $_SESSION['usuario_id'] = $usuario->getIdUsuario();
                $_SESSION['usuario_nome'] = $usuario->getNome();
                return $usuario; // Retorna o usuário autenticado
            }
        }
        return null; // Se não autenticar
    }
}
