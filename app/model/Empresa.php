<?php

namespace app\model;

use app\model\Usuario;
use ArrayObject;

class Empresa extends Usuario {
    private int $idEmpresa;
    private string $cnpj;
    private $usuarios;
    private $vagas;

    // Construtor
    
    public function __construct(
        string $nome,
        string $email,
        string $senha,
        string $cnpj,
    ) {
        parent::__construct($nome, $email, $senha);
        $this->cnpj = $cnpj;
        $this->usuarios = new ArrayObject();
        $this->vagas = new ArrayObject();
    }

    public function getIdEmpresa(): int {
        return $this->idEmpresa;
    }

    // Getters e Setters

    public function getCnpj(): string {
        return $this->cnpj;
    }

    public function getUsuarios() {
        return $this->usuarios;
    }

    public function getVagas() {
        return $this->vagas;
    }

    public function setIdEmpresa($idEmpresa){
        $this->idEmpresa = $idEmpresa;
    }

    public function addUsuario($usuario) {
        $this->usuarios->append($usuario);  // Adiciona usuario na lista de usuarios da empresa
    }

    public function addVaga($vaga) {
        $this->vagas->append($vaga);  // Adiciona vaga na lista de vagas da empresa
    }

}

?>