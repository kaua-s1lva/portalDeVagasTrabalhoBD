<?php
  session_start();
  if (!isset($_SESSION['usuario_id']) == true && !isset($_SESSION['usuario_tipo']) == 'empresa') {
    header('Location: ../index.php');
  }
?>

<?php
require_once('../model/Usuario.php');
require_once('../dao/UsuarioDAO.php');
require_once('../dao/EmpresaDAO.php');

require_once('../model/Empresa.php');

require_once('../singleton/SessaoUsuarioSingleton.php');

$usuario_logado = SessaoUsuarioSingleton::getInstance()->getUsuario();

// Verifica se o usuário é uma empresa
if (SessaoUsuarioSingleton::getInstance()->getTipoUsuario() !== 'empresa') {
  die("Acesso negado.");
}

$empresa_id = $usuario_logado->getIdUsuario();

try {
  $conexao = ConexaoSingleton::getInstancia()->getConexao();
  $stmt = $conexao->prepare("SELECT idvaga, cargo FROM vaga WHERE idempresa = ?");
  $stmt->execute([$empresa_id]);
  $vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/lista_vagas_empresa.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet" />
  <title>Controle de Vagas</title>
</head>

<body>
  <aside>
    <div class="vagas-usu-img">
      <img src="../assets/ufes-logo.png" alt="" />
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
      <h1>Controle de Vagas</h1>
      <div class="header-buttons">
        <button>Criar Nova Vaga</button>
        <button>Update</button>
      </div>
    </section>
    <section class="container">
      <table>
        <thead>
          <tr>
            <th>Descrição</th>
            <th>Contratante</th>
            <th>Opções</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($vagas)) : ?>
            <?php foreach ($vagas as $vaga) : ?>
              <tr>
                <td><?php echo htmlspecialchars($vaga['cargo']); ?></td>
                <td><?php echo htmlspecialchars($usuario_logado->getNome()); ?></td>
                <td class="buttons">
                  <button>Editar vaga</button>
                  <button>Remover vaga</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="3">Nenhuma vaga disponível.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>
</body>

</html>