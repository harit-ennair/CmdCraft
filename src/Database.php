<?php
namespace Youcode\CmdCraft;

use PDO;

class Database
{

    private $host = 'localhost';
    private $dbname = 'command_craft';
    private $username = 'root';
    private $password = '';
    private $pdo;


    public function __construct()
    {
        try {
 
            $conn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;

            $this->pdo = new PDO($conn, $this->username, $this->password);
       
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        } catch (PDOException $e) {

            echo "Connection failed: " . $e->getMessage();
        }
    }

 
    public function getConnection()
    {
        return $this->pdo;
    }
}

