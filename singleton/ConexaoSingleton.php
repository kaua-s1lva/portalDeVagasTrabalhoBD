<?php

class ConexaoSingleton
{
    private static $instancia = null;
    private $conexao;
/*
    private $host = 'localhost';
    private $port = '5432';
    private $dbname = 'dbportalvagasestagio';
    private $user = 'postgres';
    private $password = 'root';
*/
    private function __construct()
    {
        $config = parse_ini_file(__DIR__ . '/../.env');
        $_ENV = array_merge($_ENV, $config);

        try {
            $dsn = "pgsql:host={$_ENV['HOST']};port={$_ENV['PORT']};dbname={$_ENV['DBNAME']}";
            $this->conexao = new PDO($dsn, $_ENV['USER'], $_ENV['PASSWORD']);
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
