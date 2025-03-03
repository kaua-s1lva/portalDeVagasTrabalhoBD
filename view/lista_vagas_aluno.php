<?php
use app\dao\VagaDAO;

    session_start();
    if (!isset($_SESSION['usuario_id']) == true && !isset($_SESSION['usuario_tipo']) == 'aluno') {
        header('Location: ../index.php');
    }

    //require_once('../dao/IDAO.php');
    //use app\dao\IDAO;
    //require_once('../app/dao/VagaDAO.php');
    //require_once('../model/Vaga.php');
    //use app\dao\VagaDAO;

    $vagaDAO = new VagaDAO();
    $dados = $vagaDAO->findAll(); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/lista_vagas_usuario.css" />
    <link rel="stylesheet" href="../styles/modal.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Vagas disponíveis</title>
  </head>
  <body>
    <div id="modal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Adicione seu currículo</h2>
        <p>Clique no botão abaixo para enviar seu currículo em formato PDF.</p>
          <form id="uploadForm" action="../controller/crud_candidatura.php" enctype="multipart/form-data" method="POST">
            <div class="option-container">
              <p>Adicionar currículo:</p>
              <input type="hidden" name="idvaga" id="idvaga">
              <input
                type="file"
                id="curriculo"
                name="curriculo"
                accept=".pdf"
                required
              />
              <button type="submit" id="confirmar" onclick="">Enviar Arquivo</button>
          </form>
        </div>
      </div>
    </div>
    <aside>
      <img src="../assets/ufes-logo.png" alt="" />
      <span></span>
      <div class="links">
        <a href="pag_crud_aluno.php">Perfil</a>
        <a href="lista_vagas_aluno.php">Visualizar Vagas</a>
        <a href="../controller/logout.php">Log Off</a>
      </div>
    </aside>
    <main>
      <section class="header">
        <h1>Vagas disponíveis</h1>
        <button>Update</button>
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
            <?php foreach($dados as $dado) { ?>

            <tr>
              <td><?= $dado['vaga']['cargo'] ?></td>
              <td><?= $dado['usuario']['nomeusuario'] ?></td>
              <td class="buttons">
                <button data-id-vaga="<?= $dado['vaga']['idvaga'] ?>">Candidatar-se</button>
              </td>
            </tr>
            
            <?php } ?>
          </tbody>
        </table>
      </section>
    </main>
    <script src="../js/openModalVagasAluno.js"></script>
  </body>
</html>
