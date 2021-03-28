<?php 
session_start();
require_once("../_includes/db.php");

$pdo = dbConnect();

if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){    
    header("Location: ../Index.php");
    die();
}

else{
        if(count($_POST) != 0){
          
            if($_POST["number"] != ""){
                $SQLPrikaz = 'UPDATE room SET no="'.$_POST["number"].'" WHERE `room_id` LIKE "'.$_GET["RoomID"].'"';
                $stmt = $pdo->query($SQLPrikaz);
                unset($stmt);
            }
            if($_POST["name"] != ""){
                $SQLPrikaz = 'UPDATE room SET name="'.$_POST["name"].'" WHERE `room_id` LIKE "'.$_GET["RoomID"].'"';
                $stmt = $pdo->query($SQLPrikaz);
                unset($stmt);
            }
            if($_POST["phone"] != ""){
                $SQLPrikaz = 'UPDATE room SET phone="'.$_POST["phone"].'" WHERE `room_id` LIKE "'.$_GET["RoomID"].'"';
                $stmt = $pdo->query($SQLPrikaz);
                unset($stmt);
            }
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
    <form action="../Mistnosti/EditMistnost.php?RoomID=<?php 
    echo $_GET["RoomID"];
    ?>" method = "POST">
  <label for="number">číslo</label><br>
  <input type="number" id="number" name="number" value=""><br>
  <label for="name">jméno:</label><br>
  <input type="text" id="name" name="name" value=""><br><br>
  <label for="phone">telefon:</label><br>
  <input type="number" id="phone" name="phone" value=""><br><br>
  <input type="submit" value="Edit"><br>
  <a href="Mistnosti.php"> zpět na místnosti </a>
</form>
    </body>
</html>