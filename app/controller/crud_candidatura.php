<?php

use app\dao\CandidaturaDAO;
use app\model\Candidatura;
use app\singleton\SessaoUsuarioSingleton;

session_start();

// Verifica se o formulário foi enviado via POST e se o arquivo foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['curriculo'])) {
    // Verifica se ocorreu algum erro no upload
    if ($_FILES['curriculo']['error'] === UPLOAD_ERR_OK) {
        // Caminho temporário e informações do arquivo
        $fileTmpPath = $_FILES['curriculo']['tmp_name'];
        $fileName    = $_FILES['curriculo']['name'];
        $fileSize    = $_FILES['curriculo']['size'];
        $fileType    = $_FILES['curriculo']['type'];

        $idvaga         = isset($_POST['idvaga']) ? $_POST['idvaga'] : '';
        
        // Verifica a extensão do arquivo
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExtension !== 'pdf') {
            echo "<script>
                    alert('Apenas arquivos PDF são permitidos.');
                    window.history.back();
                  </script>";
            exit;
        }
        
        // Lê o conteúdo do arquivo
        $fileContent = file_get_contents($fileTmpPath);
        if ($fileContent === false) {
            echo "<script>
                    alert('Erro ao ler o arquivo.');
                    window.history.back();
                  </script>";
            exit;
        }

        //print_r($fileContent);

        $idusuario = SessaoUsuarioSingleton::getInstance()->getUsuario()->getIdUsuario();

        $dao = new CandidaturaDAO();
        $dao->insert(new Candidatura($idvaga, $idusuario, $fileContent, 1));
        /*
        // Conecta ao banco de dados (supondo que a conexão seja obtida via ConexaoSingleton)
        $conexao = ConexaoSingleton::getInstancia()->getConexao();
        
        // Exemplo de query para inserir o arquivo PDF no banco (tabela 'curriculos')
        $sql = "INSERT INTO curriculos (usuario_id, arquivo_pdf, nome_arquivo, tamanho, tipo, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conexao->prepare($sql);
        
        // Supondo que o ID do usuário esteja armazenado na sessão
        $usuario_id = $_SESSION['usuario_id'];
        
        // Executa a query passando os parâmetros. Observe o uso de PDO::PARAM_LOB para dados binários.
        $stmt->bindParam(1, $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $fileContent, PDO::PARAM_LOB);
        $stmt->bindParam(3, $fileName);
        $stmt->bindParam(4, $fileSize, PDO::PARAM_INT);
        $stmt->bindParam(5, $fileType);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Currículo enviado com sucesso!');
                    window.location.href = '../view/lista_vagas_aluno.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Erro ao enviar o currículo.');
                    window.history.back();
                  </script>";
        }
                  */
        
    } else {
        echo "<script>
                alert('Erro no upload do arquivo.');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Requisição inválida.');
            window.history.back();
          </script>";
}
?>
