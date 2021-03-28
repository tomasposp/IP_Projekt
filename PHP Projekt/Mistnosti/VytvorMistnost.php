<?php 

session_start();
require_once("../_includes/db.php");


error_reporting(-1);
ini_set('display_errors', 'On');


$pdo = dbConnect();

if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){    
    header("Location: ../Index.php");
    die();
}
else{
    
        if($_POST["number"] != "" && $_POST["name"] != "" && $_POST["phone"] != ""){
            $SQLPrikaz = 'INSERT INTO `room`(`no`, `name`, `phone`) VALUES ("'.$_POST["number"].'", "'.$_POST["name"].'", "'.$_POST["phone"].'")';
            $stmt = $pdo->query($SQLPrikaz);
            unset($stmt);

            echo "<a href='../Mistnosti/Mistnosti.php'>zpět na Místnosti</a>";
        }

    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="../includes/bootstrap.css">
    </head>
    <body>
    <form action="VytvorMistnost.php" method = "POST">
  <label for="number">číslo</label><br>
  <input type="number" id="number" name="number" value=""><br>
  <label for="name">jméno:</label><br>
  <input type="text" id="name" name="name" value=""><br><br>
  <label for="phone">telefon:</label><br>
  <input type="number" id="phone" name="phone" value=""><br><br>
  <input type="submit" value="Vytvořit">
</form>
    </body>
</html>