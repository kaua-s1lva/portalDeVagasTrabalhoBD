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
          <form id="uploadForm" action="/egresso/indicar" enctype="multipart/form-data" method="POST">
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
        <a href="/egresso/visualizar">Perfil</a>
        <a href="/egresso"><b>Indicação de Vagas</b></a>
        <a href="/usuario/logout">Log Off</a>
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
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($dados as $dado) { ?>
              <tr>
                <td><?= $dado['vaga']['cargo'] ?></td>
                <td class="buttons">
                  <button data-id-vaga="<?= $dado['vaga']['idvaga'] ?>">Indicar vaga</button>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </section>
    </main>
    <script src="/js/openModalIndicacaoEgresso.js"></script>
  </body>
</html>
