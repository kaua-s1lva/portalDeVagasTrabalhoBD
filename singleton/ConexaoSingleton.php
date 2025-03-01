<?php

class ConexaoSingleton
{
    private static $instancia = null;
    private $conexao;

    private $host = 'localhost';
    private $port = '5432';
    private $dbname = 'bdportalvagasestagio';
    private $user = 'postgres';
    private $password = 'root';

    private function __construct()
    {
        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->conexao = new PDO($dsn, $this->user, $this->password);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conexão com PostgreSQL estabelecida!\n";
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    // Impede clonagem do objeto
    private function __clone() {}

    // Impede desserialização do objeto
    public function __wakeup()
    {
        throw new Exception("Não é permitido desserializar Singleton.");
    }

    public static function getInstancia(){
        if(self::$instancia === null){
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    public function getConexao(){
        return $this->conexao;
    }

}

?>
