<?php

    class AlunoDAO extends UsuarioDAO {
        public function insert($aluno) {
            $idUsuario = parent::insert($aluno);
            $stmt = $this->conexao->prepare("INSERT INTO aluno (idAluno, cpf) VALUES (?, ?)");
            $stmt->execute([$idUsuario, $aluno->getCpf()]);
        }
        
        public function update($aluno) {
            parent::update($aluno);
            $stmt = $this->conexao->prepare("UPDATE aluno SET cpf=? WHERE idAluno=?");
            $stmt->execute([$aluno->cpf, $aluno->idUsuario]);
        }
        
        public function delete($id) {
            $stmt = $this->conexao->prepare("DELETE FROM aluno WHERE idAluno=?");
            $stmt->execute([$id]);
            parent::delete($id);
        }
        
        public function findById($id) {
            $stmt = $this->conexao->prepare("SELECT u.*, a.cpf FROM usuario u JOIN aluno a ON u.idUsuario = a.idAluno WHERE u.idUsuario=?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? new Aluno($result['idUsuario'], $result['nome'], $result['email'], $result['senha'], $result['cpf']) : null;
        }

        public function findByEmail($email) {
            // Prepara a query SQL com junção (JOIN) para buscar o aluno pelo e-mail
            $stmt = $this->conexao->prepare("SELECT u.*, a.cpf FROM usuario u JOIN aluno a ON u.idUsuario = a.idAluno WHERE u.email = ?");
            
            // Executa a consulta passando o e-mail como parâmetro
            $stmt->execute([$email]);
            
            // Obtém o resultado
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se encontrar o usuário, retorna um objeto Aluno com os dados
            return $result ? new Aluno($result['idUsuario'], $result['nome'], $result['email'], $result['senha'], $result['cpf']) : null;
        }
        
        public function findAll() {
            $stmt = $this->conexao->query("SELECT u.*, a.cpf FROM usuario u JOIN aluno a ON u.idUsuario = a.idAluno");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $alunos = [];
            foreach ($result as $row) {
                $alunos[] = new Aluno($row['idUsuario'], $row['nome'], $row['email'], $row['senha'], $row['cpf']);
            }
            return $alunos;
        }

    }

?>