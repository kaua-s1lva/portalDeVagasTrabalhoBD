<?php
  session_start();
  if (!isset($_SESSION['usuario_id']) == true && !isset($_SESSION['usuario_tipo']) == 'egresso') {
    header('Location: ../index.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/lista_indicacoes_egresso.css" />
    <link rel="stylesheet" href="../styles/modalIndicacaoEgresso.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Indicação de Vagas</title>
  </head>
  <body>
    <div id="modal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Inserir E-mail Para Indicação</h2>
        <p>No campo abaixo digite o e-mail que deseja indicar:</p>
          <form id="uploadForm" action="../controller/crud_candidatura.php" enctype="multipart/form-data" method="POST">
            <div class="option-container">
              <p>Adicionar e-mail:</p>
              <input type="hidden" name="idvaga" id="idvaga">
              <input
                type="text"
                id="emailAluno"
                name="emailAluno"
                required
              />
              <button type="submit" id="confirmar" onclick="">Enviar</button>
          </form>
        </div>
      </div>
    </div>
    <aside>
      <div class="vagas-usu-img">
        <img src="../assets/ufes-logo.png" alt="" />
      </div>
      <div class="links">
        <a href="">Perfil</a>
        <a href="">Indicação de Vagas</a>
        <a href="../controller/logout.php">Log Off</a>
      </div>
    </aside>
    <main>
      <section class="header">
        <h1>Vagas Disponíveis Para Indicação</h1>
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
            <tr>
              <td>Desenvolvedor Web Júnior</td>
              <td>Stacks LTDA</td>
              <td class="buttons">
                <button>Indicar vaga</button>
              </td>
            </tr>
            <tr>
              <td>Analista De Dados Junior</td>
              <td>Unreal Data</td>
              <td class="buttons">
                <button>Indicar vaga</button>
              </td>
            </tr>
          </tbody>
        </table>
      </section>
    </main>
    <script src="/js/openModalIndicacaoEgresso.js"></script>
  </body>
</html>
