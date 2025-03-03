<?php
session_start();

use app\dao\AlunoDAO;
use app\model\Aluno;
use app\singleton\SessaoUsuarioSingleton;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $instancia = SessaoUsuarioSingleton::getInstance();
    $usuario_logado = $instancia->getUsuario();
    $dao = new AlunoDAO();
    if (isset($_POST['salvar'])) {
        // Resgata os dados enviados pelo formulário
        $nome      = isset($_POST['nome']) ? $_POST['nome'] : '';
        $email     = isset($_POST['email']) ? $_POST['email'] : '';
        $senha     = isset($_POST['senha']) ? $_POST['senha'] : '';
        $cpf       = isset($_POST['cpf']) ? $_POST['cpf'] : '';

        if (strlen($cpf) == 11) {
            $aluno = new Aluno($nome, $email, $senha, $cpf);
            $aluno->setIdAluno($usuario_logado->getIdAluno());
            $aluno->setIdUsuario($usuario_logado->getIdUsuario());

            if ($dao->update($aluno)) {
                echo "<script> alert('Dados do aluno atualizados com sucesso!'); window.location.href = '../view/pag_crud_aluno.php'; </script>";
                exit();
            }
        } else {
            echo "CPF inválido";
        }
    } else if (isset($_POST['excluir'])) {

        $dao = new AlunoDAO();
        $dao->delete($usuario_logado->getIdUsuario());

        $instancia->logout();
    }
} else {
    echo "Método de requisição inválido.";
}
