<?php
namespace Youcode\CmdCraft;
include $_SERVER['DOCUMENT_ROOT'].'/CmdCraft/vendor/autoload.php';

use Youcode\CmdCraft\Database;
use Youcode\CmdCraft\user;



class clien extends user {
    private $pdo;
    private $activety;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }





    public function registerFunc($name, $email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $myuser = $stmt->fetch();


        if ($myuser) {
             
            echo '<script>alert("the user is already registreed")</script>';

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
    
     
        if(!$myuser || !password_verify($password,$myuser["password"])){
            echo '<script>alert("the email or password is not correct")</script>';
            return;
        }
     
        if ($myuser["activety"]=="0") {
            echo '<script>alert("Your Account is Not Active Anymore")</script>';
            return;
        }
        if ($myuser["role"]=="admin") {
            header("location:./pages/adminpaje.php");
        }else{
            header("location:./pages/clienpaje.php");
        }
    }








    public function affichage()
    {
        $sql = "SELECT * FROM users WHERE role = 'client'"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach ($users as $user) {
            echo '<tr class="row-user">';
            echo '<td class="column-name">' . $user['name'] . '</td>';
            echo '<td class="column-email">' . $user['email'] . '</td>';
            if ($user['activety'] == '1') {
                echo '<td class="column-status active">
                    <a href="../src/clien.php?id=' . $user['id'] . '&activety=0" class="act" >Disactive</a>
                 

                </td>';
            } else {
                echo '<td>
                    <a href="../src/clien.php?id=' . $user['id'] . '&activety=1" class="act">Active</a>
                 
                </td>';
            }
            echo '</tr>';
        }
    }
    
    public function updateactivety($id, $activety)
    {
        $userId = $id;
        $newactivety = $activety;
        $sql = "UPDATE users SET activety = :activety WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':activety' => $newactivety,
            ':id' => $userId
        ]);
    }

}
if(isset($_GET['id']) && isset($_GET['activety'])){
        $ndb = new Database;
        $pdo = $ndb->getConnection();
        $descative = new clien($pdo);
        $descative->updateactivety($_GET['id'],$_GET['activety']);
        header('location:http://localhost/CmdCraft/pages/Utilisateur.php');
}
