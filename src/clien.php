<?php
namespace Youcode\CmdCraft;
include $_SERVER['DOCUMENT_ROOT'].'/CmdCraft/vendor/autoload.php';

use Youcode\CmdCraft\Database;
use Youcode\CmdCraft\user;



class clien extends user {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }





    public function registerFunc($name, $email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $myuser = $stmt->fetch();


        if ($myuser) {

            // echo("the user is already registreed");
        }else{

 
            $hashedpassord = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO users (name,email,password,role,activety)VALUES(?,?,?,'client','1')");
            $stmt->execute([$name, $email, $hashedpassord]);

        }
    }





    public function loginFunc($email,$password){

      
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $myuser = $stmt->fetch();
    
        if($myuser && password_verify($password,$myuser["password"])){
    
    
           $_SESSION["userid"]=$myuser["id"];
           $_SESSION["email"]=$myuser["email"];
           $_SESSION["role"]=$myuser["role"];
    
    
           if ($myuser["role"]=="admin") {
            header("location:./pages/adminpaje.php");
           }else{
            header("location:./pages/clienpaje.php");
    
           }
    
    
        }
    }


}

