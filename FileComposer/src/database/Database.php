<?php
namespace Src\Database;

use PDO;

class Database{
    private PDO $pdo;
    private PDO $userPDO;

    public function  __construct(private string $dbname, private string $host, private string $username, private string $password){
        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public function getPDO(): PDO{

        return $this->pdo ?? $this->pdo = new PDO("mysql:dbname={$this->dbname};host={$this->host}", $this->username, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);;
    }

    public function getUserPDO(): PDO{

        return $this->userPDO ?? $this->userPDO = new PDO("mysql:dbname=phpplay;host=localhost", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}