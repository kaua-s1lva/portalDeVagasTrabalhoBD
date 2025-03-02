<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
  header('Location: login_screen.html');
  exit();
}
?>

<?php
require_once('../model/Usuario.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/EmpresaDAO.php');
require_once('../model/Empresa.php');
require_once('../dao/EgressoDAO.php');
require_once('../model/Egresso.php');
require_once('../singleton/SessaoUsuarioSingleton.php');
require_once('../singleton/ConexaoSingleton.php');

$usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();

// Verifica se o usuário é uma empresa
if (SessaoUsuarioSingleton::getInstance()->getTipoUsuario() !== 'empresa') {
  die("Acesso negado.");
}

$empresa_id = $usuario_logado->getIdUsuario();
$egressoDAO = new EgressoDAO();
try {
  $egressos = $egressoDAO->findAllByIdEmpresa($empresa_id);
} catch (PDOException $e) {
  die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/lista_edicao_perfil_egresso.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet" />
  <title>Gestão de Egressos</title>
</head>

<body>
  <aside>
    <div class="vagas-usu-img">
      <img src="../assets/ufes-logo.png" alt="Logo UFES" />
    </div>
    <div class="links">
      <a href="pag_crud_empresa.php">Perfil</a>
      <a href="lista_edicao_perfil_egresso.php">Egressos</a>
      <a href="lista_vagas_empresa.php">Vagas</a>
      <a href="logout.php">Log Off</a>
    </div>
  </aside>
  <main>
    <section class="header">
      <h1>Gestão de Egressos</h1>
      <div class="header-buttons">
        <button onclick="window.location.href='../view/empresa_cadastro_egresso.php'">Adicionar Novo Egresso</button>
        <button onclick="location.reload();">Atualizar</button>
      </div>
    </section>
    <section class="container">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Data de Cadastro</th>
            <th>Opções</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($egressos)) : ?>
            <?php foreach ($egressos as $egresso) : ?>
              <tr>
                <td><?php echo htmlspecialchars($egresso->nome); ?></td>
                <td><?= date("d/m/Y", strtotime($egresso->created_at)) ?></td>
                <td class="buttons">
                  <button onclick="editarEgresso()">Editar</button>
                  <button onclick="removerEgresso()">Remover</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="3">Nenhum egresso cadastrado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>

  <script>
    function editarEgresso() {
      window.location.href = `empresa_editar_egresso.php`;
    }

    function removerEgresso() {
      if (confirm("Tem certeza que deseja remover este egresso?")) {
        window.location.href = `../controller/crud_egresso.php?action=delete`;
    }
    }
  </script>
</body>

</html>