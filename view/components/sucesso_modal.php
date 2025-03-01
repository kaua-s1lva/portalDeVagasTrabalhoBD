<?php
// ... processamento do cadastro e inserção no banco ...

// Exibe o HTML da página com o modal e o script para redirecionar
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro Realizado com Sucesso</title>
  <!-- Inclua o Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <!-- Inclua o modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Cadastro Realizado com Sucesso!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Seu cadastro foi realizado com sucesso! Você será redirecionado para a página de login em alguns segundos.
        </div>
        <div class="modal-footer">
          <a href="../view/login_screen.html" class="btn btn-primary">Ir para Login Agora</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Inclua as dependências JS do Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // Quando a página carregar, exiba o modal
    $(document).ready(function(){
      $('#confirmModal').modal('show');
      // Redireciona após 5 segundos
      setTimeout(function(){
         window.location.href = "../login_screen.html";
      }, 5000);
    });
  </script>
</body>
</html>
