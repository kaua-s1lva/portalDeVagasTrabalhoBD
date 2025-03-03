<?php
require_once('../model/Usuario.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/EmpresaDAO.php');

require_once('../model/Empresa.php');

require_once('../singleton/SessaoUsuarioSingleton.php');

session_start();

// Verificar se o usuário está logado como empresa
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
  header('Location: ../index.php');
  exit();
}

$empresa = SessaoUsuarioSingleton::getInstance()->getUsuario();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/pag_crud_empresa.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet" />
  <title>Manter Empresa</title>
</head>

<body>
  <aside>
    <div class="vagas-usu-img">
      <img src="../assets/ufes-logo.png" alt="ufes-logo" />
    </div>
    <div class="links">
      <a href="pag_crud_empresa.php">Perfil</a>
      <a href="lista_edicao_perfil_egresso.php">Egressos</a>
      <a href="lista_vagas_empresa.php">Vagas</a>
      <a href="../controller/logout.php">Log Off</a>
    </div>
  </aside>
  <main>
    <section class="header">
      <h1>Atualizar Dados da Empresa</h1>
    </section>
    <section class="container">
      <form id="loginForm" method="POST" action="../controller/crud_empresa.php">
        <div class="crud-form-input">
          <div class="inplbl">
            <label for="razao_social">Razão Social:</label>
            <input type="text" id="razao_social" name="razao_social" value="<?php echo htmlspecialchars($empresa->getNome()); ?>" required />
          </div>
          <div class="inplbl">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($empresa->getEmail()); ?>" required />
          </div>
          <div class="inplbl">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" value="<?php echo htmlspecialchars($empresa->getSenha()); ?>" required />
          </div>
          <div class="inplbl">
            <label for="cnpj">CNPJ:</label>
            <input type="text" id="cnpj" name="cnpj" readonly value="<?php echo htmlspecialchars($empresa->getCnpj()); ?>" />
          </div>
        </div>
        <div class="crud-form-buttons">
          <div class="crud-form-buttons">
            <button type="submit" id="salvar" name="salvar">Salvar</button>
            <button type="submit" id="excluir" name="excluir" onclick="return confirm('Tem certeza que deseja excluir esta empresa?');">Excluir</button>
          </div>
        </div>
      </form>
    </section>
  </main>
</body>

</html>