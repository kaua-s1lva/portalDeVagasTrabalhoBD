<?php

use dao\AlunoDAO;
use model\Aluno;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Resgata os dados enviados pelo formulário
    $nome      = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email     = isset($_POST['email']) ? $_POST['email'] : '';
    $senha     = isset($_POST['senha']) ? $_POST['senha'] : '';
    $cpf_cnpj  = isset($_POST['cpf_cnpj']) ? $_POST['cpf_cnpj'] : '';

    $aluno = new Aluno($nome, $email, $senha, $cpf_cnpj);
    $dao = new AlunoDAO();
    $dao->insert($aluno);

    // Exemplo de como utilizar os dados: exibindo-os
    echo "<h2>Dados Recebidos:</h2>";
    echo "<p>Nome: " . htmlspecialchars($nome) . "</p>";
    echo "<p>E-mail: " . htmlspecialchars($email) . "</p>";
    echo "<p>Senha: " . htmlspecialchars($senha) . "</p>";
    echo "<p>CPF / CNPJ: " . htmlspecialchars($cpf_cnpj) . "</p>";

    // Aqui você pode incluir a lógica para validar, processar e armazenar os dados em um banco de dados
} else {
    echo "Método de requisição inválido.";
}
