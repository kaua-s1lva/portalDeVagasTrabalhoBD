<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/lista_vagas_aluno.css" />
    <link rel="stylesheet" href="../styles/modal.css" />
    <link rel="stylesheet" href="../styles/tableScroll.css">
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
          <form id="uploadForm" action="/aluno/candidatar" enctype="multipart/form-data" method="POST">
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
        <a href="aluno/visualizar">Perfil</a>
        <a href="/aluno"><b>Visualizar Vagas</b></a>
        <a href="/usuario/logout">Log Off</a>
      </div>
    </aside>
    <main>
      <section class="header">
        <h1>Vagas disponíveis</h1>
      </section>
      <section class="container">
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Descrição</th>
                <th>Contratante</th>
                <th>Opções</th>
              </tr>
            </thead>
            <tbody>
            <?php
              // Extraindo os IDs das vagas que o usuário já se candidatou
              $appliedVagas = array_map(function($candidatura) {
                  return $candidatura->idvaga;
              }, $candidaturas);
              ?>
  
              <?php foreach($dados as $dado) { ?>
                <tr>
                  <td><?= $dado['vaga']['cargo'] ?></td>
                  <td><?= $dado['usuario']['nomeusuario'] ?></td>
                  <td class="buttons">
                    <?php if (in_array($dado['vaga']['idvaga'], $appliedVagas)) { ?>
                        <span class="status-cand">Enviado</span>
                        <button disabled data-id-vaga="<?= $dado['vaga']['idvaga'] ?>">Já se candidatou</button>
                    <?php } else { ?>
                        <span class="status-cand active">Não enviado</span>
                        <button data-id-vaga="<?= $dado['vaga']['idvaga'] ?>">Candidatar-se</button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
    <script src="../js/openModalVagasAluno.js"></script>
  </body>
</html>
