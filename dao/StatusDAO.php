<?php

class StatusDAO implements IDAO {
    private $conexao;
    
    public function __construct(PDO $conexao) {
        $this->conexao = $conexao;
    }
    
    public function insert($status) {
        $stmt = $this->conexao->prepare("INSERT INTO status (nome, descricao) VALUES (?, ?)");
        $stmt->execute([$status->nome, $status->descricao]);
    }
    
    public function update($status) {
        $stmt = $this->conexao->prepare("UPDATE status SET nome=?, descricao=? WHERE idstatus=?");
        $stmt->execute([$status->nome, $status->descricao, $status->idstatus]);
    }
    
    public function delete($id) {
        $stmt = $this->conexao->prepare("DELETE FROM status WHERE idstatus=?");
        $stmt->execute([$id]);
    }

    public function findById($id) {
        $sql = "SELECT * FROM status WHERE idstatus=?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result) {
            return new Status(
                $result['idstatus'],
                $result['nome'],
                $result['descricao']
            );
        }
        return null;
    }
    
    public function findAll() {
        $sql = "SELECT * FROM status";
        $stmt = $this->conexao->query($sql);
        $result = $stmt->fetchAll();

        $status = [];
        foreach ($result as $row) {
            $status[] = new Status(
                $row['idstatus'],
                $row['nome'],
                $row['descricao']
            );
        }
        return $status;
    }
}

?>