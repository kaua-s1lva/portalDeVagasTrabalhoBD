<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/lista_vagas_empresa.css" />
  <link rel="stylesheet" href="../styles/modalListaVagasEmpresa.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet" />
  <title>Controle de Vagas</title>
</head>

<body>
  <div id="modal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Insira os Dados da Vaga</h2>
      <p>Preencha os campos abaixo referentes à vaga que deseja criar:</p>
      <form id="uploadForm" action="/empresa/criarvaga" enctype="multipart/form-data" method="POST">
        <div class="option-container">
          <p>Cargo:</p>
          <input type="hidden" name="idvaga" id="idvaga">
          <input
            type="text"
            id="cargo"
            name="cargo"
            placeholder="Ex: Desenvolvedor..."
            required />
          <p>Status da vaga:</p>
          <select name="selVaga" id="selVaga">
            <option value="1">Em aberto</option>
            <option value="2">Em triagem</option>
            <option value="3">Em entrevista</option>
            <option value="4">Concluído</option>
          </select>
          <button type="submit" id="confirmar">Enviar</button>
        </div>
      </form>
    </div>
  </div>
  <aside>
    <div class="vagas-usu-img">
      <img src="../assets/ufes-logo.png" alt="" />
    </div>
    <div class="links">
      <a href="/empresa/egressos">Egressos</a>
      <a href="/empresa/perfil">Perfil</a>
      <a href="/empresa/vagas">Vagas</a>
      <a href="../controller/logout.php">Log Off</a>
    </div>
  </aside>
  <main>
    <section class="header">
      <h1>Controle de Vagas</h1>
      <div class="header-buttons">
        <button>Criar Nova Vaga</button>
      </div>
    </section>
    <section class="container">
      <table>
        <thead>
          <tr>
            <th>Cargo</th>
            <th>Status</th>
            <th>Total de Inscrições</th>
            <th>Opções</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($vagas)) : ?>
            <?php foreach ($vagas as $vaga) : ?>
              <tr>
                <td><?php echo htmlspecialchars($vaga['cargo']); ?></td>
                <td><?php echo ucfirst(htmlspecialchars($vaga['nome_etapa'])); ?></td>
                <td><?php echo htmlspecialchars($vaga['total_inscricoes']); ?></td>
                <td class="buttons">
                  <button onclick="visualizarVaga(<?php echo($vaga['idvaga']); ?>)">Visualizar vaga</button>
                  <button onclick="removerVaga(<?php echo($vaga['idvaga']); ?>)">Remover vaga</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4">Nenhuma vaga disponível.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>
  <script>
    function visualizarVaga(idVaga) {
      window.location.href = "/empresa/rendervaga/" + idVaga;
    }

    function removerVaga(idVaga) {
      if (confirm("Tem certeza que deseja remover esta vaga?")) {
        window.location.href = "/empresa/removervaga/" + idVaga;
      }
    }
  </script>
  <script src="/js/openModalListaVagasEmpresa.js"></script>
</body>

</html>