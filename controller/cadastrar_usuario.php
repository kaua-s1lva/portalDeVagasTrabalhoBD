<?php
require_once('../model/Usuario.php');
require_once('../model/Aluno.php');
require_once('../model/Empresa.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/AlunoDAO.php');
require_once('../dao/EmpresaDAO.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Resgata os dados enviados pelo formulário
    $nome      = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email     = isset($_POST['email']) ? $_POST['email'] : '';
    $senha     = isset($_POST['senha']) ? $_POST['senha'] : '';
    $cpf_cnpj  = isset($_POST['cpf_cnpj']) ? $_POST['cpf_cnpj'] : '';

    if (strpos($email, "@edu.ufes.br") !== false && strlen($cpf_cnpj) == 11) {
        $aluno = new Aluno($nome, $email, $senha, $cpf_cnpj);
        $dao = new AlunoDAO();
        $dao->insert($aluno);

        echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = '../index.php';
            </script>";
    } else if (strlen($cpf_cnpj == 14)) {
        $empresa = new Empresa($nome, $email, $senha, $cpf_cnpj);
        $dao = new EmpresaDAO();
        $dao->insert($empresa);

        echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = '../index.php';
            </script>";
    } else {
        echo "<script>
                alert('CPF ou CNPJ inválido!');
                window.history.back();
            </script>";

    }
    
} else {
    echo "Método de requisição inválido.";
}
