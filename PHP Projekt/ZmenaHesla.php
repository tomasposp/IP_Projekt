<?php 
session_start();
require_once("_includes/db.php");

$pdo = dbConnect();
if(count($_POST) == 3){
    if ($_POST["passwordOld"] !="" && $_POST["password1"] !="" && $_POST["password2"] !=""){

        if($_POST["password1"] != $_POST["password2"]){
            echo "nová hesla nejsou stejná";
        }
        else {
            $SQLPrikaz = 'UPDATE employee SET password="'.$_POST["password1"].'" WHERE `login` LIKE "'.$_SESSION["username"].'"';
            $stmt = $pdo->query($SQLPrikaz);

            echo "heslo bylo změněno";
         }
}
else{
    echo "Nelze změnit heslo";
}
}




?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
    <form action="/ZmenaHesla.php" method = "POST">
  <label for="passwordOld">Staré heslo</label><br>
  <input type="password" id="passwordOld" name="passwordOld" value=""><br>
  <label for="password1">Nové heslo:</label><br>
  <input type="password" id="password1" name="password1" value=""><br><br>
  <label for="password2">Nové heslo znovu:</label><br>
  <input type="password" id="password2" name="password2" value=""><br><br>
  <input type="submit" value="Změna hesla">
</form>
    </body>
</html>