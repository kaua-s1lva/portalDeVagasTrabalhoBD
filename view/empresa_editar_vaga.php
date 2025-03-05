<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle de Vagas</title>
  <link rel="stylesheet" href="/styles/empresa_editar_vaga.css">
  <link rel="stylesheet" href="/styles/modalEditarVagasEmpresa.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<body>

  <!-- Modal de Edição da Vaga -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Editar os Dados da Vaga</h2>
      <p>Preencha os campos abaixo referentes à vaga que deseja editar:</p>
      <form id="uploadForm" action="/empresa/editarvaga" enctype="multipart/form-data" method="POST">
        <div class="option-container">
          <p>Cargo:</p>

          <input type="hidden" name="idvaga" id="idvaga">
          <input type="text" id="cargo" name="cargo" placeholder="Ex: Desenvolvedor..." required value="<?= htmlspecialchars($vaga['cargo'] ?? '') ?>">

          <p>Etapa da vaga:</p>
          <select name="etapaVaga" id="etapaVaga">
            <?php var_dump($vaga['nome_etapa']); ?>
            <option value="1" <?= isset($vaga['nome_etapa']) && $vaga['nome_etapa'] == "Em aberto" ? 'selected' : '' ?>>Em Aberto</option>
            <option value="2" <?= isset($vaga['nome_etapa']) && $vaga['nome_etapa'] == "Em triagem" ? 'selected' : '' ?>>Em Triagem</option>
            <option value="3" <?= isset($vaga['nome_etapa']) && $vaga['nome_etapa'] == "Em entrevista" ? 'selected' : '' ?>>Em Entrevista</option>
            <option value="4" <?= isset($vaga['nome_etapa']) && $vaga['nome_etapa'] == "Concluído" ? 'selected' : '' ?>>Concluído</option>
          </select>
          <button type="submit" id="confirmar">Salvar Alterações</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Barra Lateral -->
  <aside>
    <div class="vagas-usu-img">
      <img src="/assets/ufes-logo.png" alt="Logo UFES">
    </div>
    <div class="links">
      <a href="/empresa/egressos">Egressos</a>
      <a href="/empresa/perfil">Perfil</a>
      <a href="/empresa/vagas"><b>Vagas</b></a>
      <a href="/usuario/logout">Log Off</a>
    </div>
  </aside>

  <!-- Conteúdo Principal -->
  <main>
    <section class="header">
      <h1>Detalhes da Vaga</h1>
      <div class="header-buttons">
        <button data-id-vaga="<?= $vaga['idvaga'] ?>">Editar Vaga</button>
      </div>
    </section>

    <section class="container">
      <!-- Filtros -->
      <section class="filtro-vaga">
        <div>
          <label for="cargoFiltro">Cargo:</label>
          <input type="text" id="cargoFiltro" value="<?= htmlspecialchars($vaga['cargo'] ?? '') ?>" readonly>
        </div>
        <div>
          <label for="etapaFiltro">Etapa:</label>
          <input type="text" id="etapaFiltro" value="<?= ucwords(htmlspecialchars($vaga['nome_etapa']) ?? '') ?>" readonly>
        </div>
      </section>

      <!-- Tabela de Candidatos -->
      <table>
        <thead>
          <tr>
            <th>Candidato</th>
            <th>Indicado Por</th>
            <th>Opções</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($candidatos)): ?>
            <?php foreach ($candidatos as $candidato): ?>
              <tr>
                <td><?= htmlspecialchars($candidato['nome_candidato']) ?></td>
                <td><?= htmlspecialchars($candidato['nome_egresso_indicador'] ?? 'N/A') ?></td>
                <td class="buttons">
                  <?php if (!empty($candidato['curriculo'])): ?>
                    <a href="/empresa/visualizar/curriculo/<?= $candidato['id_candidato'] ?>" target="_blank">Ver Currículo</a>
                  <?php else: ?>
                    <button disabled>Currículo não disponível</button>
                  <?php endif; ?>
                </td>

              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="3">Nenhum candidato cadastrado para esta vaga.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>

  <script src="/js/openModalEditarVagasEmpresa.js"></script>
</body>

</html>