<?php
require_once('../dao/UsuarioDAO.php');
class Aluno extends Usuario {
    private int $idAluno;
    private string $cpf;
    private $candidaturas;

    // Construtor
    
    public function __construct(
        string $nome,
        string $email,
        string $senha,
        string $cpf,
    ) {
        parent::__construct($nome, $email, $senha);
        $this->cpf = $cpf;
        $this->candidaturas = new ArrayObject();
    }

    // Getters


  public function getIdAluno(): int {
        return $this->idAluno;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function getCandidaturas() {
        return $this->candidaturas;
    }

    public function addCandidatura($candidatura) {
        $this->candidaturas->append($candidatura);
    }

    // setters
  
    public function setIdAluno($idAluno){
        $this->idAluno = $idAluno;
    }
}

?>