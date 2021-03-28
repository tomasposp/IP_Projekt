<?php 
session_start();
require_once("_includes/db.php");

$pdo = dbConnect();

if (array_key_exists("username",$_POST)){

        $SQLPrikaz = 'SELECT * FROM employee WHERE `login` LIKE "'.$_POST["username"].'"';
        $stmt = $pdo->query($SQLPrikaz);
       
    
    if ($stmt -> rowCount() == 0){
        echo "Jméno nebylo nalezeno.";
    }
    else{
        while ($row = $stmt->fetch()) {
            if($row["password"] == $_POST["password"]){

                
                $_SESSION['username'] = $row["login"];
                $_SESSION['admin'] = $row["admin"];

                header("Location: /Rozcestnik.php");
                die();

                echo "Přihlášení bylo úspěšné";
            }
            else{
                echo "Špatné heslo";
            }
        }
    }
}
else{
    $_SESSION = []; //vymažu všechna data
session_destroy();

}



?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
    <form action="/Index.php" method = "POST">
  <label for="fname">Username</label><br>
  <input type="text" id="username" name="username" value=""><br>
  <label for="lname">Password:</label><br>
  <input type="password" id="password" name="password" value=""><br><br>
  <input type="submit" value="Login">
</form>
    </body>
</html>