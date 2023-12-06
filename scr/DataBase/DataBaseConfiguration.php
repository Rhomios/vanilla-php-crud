<?php
class DataBaseConfiguration
{
    private $host;
    private $port;
    private $dbName;
    private $dbUser;
    private $dbUserPassword;
    private $pdo;

    public function __construct($host, $port, $dbName, $dbUser, $dbUserPassword)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbUserPassword = $dbUserPassword;
        $this->connect();
    }

    private function connect()
    {
        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbName};options='--client_encoding=UTF8'";
            $this->pdo = new PDO($dsn, $this->dbUser, $this->dbUserPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $error) {
            die("Connection failed: " . $error->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}