<?php 
session_start();
require_once("../_includes/db.php");
$pdo = dbConnect();


if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){    
    header("Location: ../Index.php");
    die();
}

else{
    if (count($_POST) != 0){

    if($_POST["name"] != ""){
        $SQLPrikaz = 'UPDATE employee SET name="'.$_POST["name"].'" WHERE `employee_id` LIKE "'.$_GET["ZameID"].'"';
        $stmt = $pdo->query($SQLPrikaz);
        unset($stmt);
    }
    if($_POST["surname"] != ""){
        $SQLPrikaz = 'UPDATE employee SET surname="'.$_POST["surname"].'" WHERE `employee_id` LIKE "'.$_GET["ZameID"].'"';
        $stmt = $pdo->query($SQLPrikaz);
        unset($stmt);
    }
    if($_POST["job"] != ""){
        $SQLPrikaz = 'UPDATE employee SET job="'.$_POST["job"].'" WHERE `employee_id` LIKE "'.$_GET["ZameID"].'"';
        $stmt = $pdo->query($SQLPrikaz);
        unset($stmt);
    }
    if($_POST["wage"] != ""){
        $SQLPrikaz = 'UPDATE employee SET wage="'.$_POST["wage"].'" WHERE `employee_id` LIKE "'.$_GET["ZameID"].'"';
        $stmt = $pdo->query($SQLPrikaz);
        unset($stmt);
    }
    $SQLPrikaz = 'UPDATE employee SET room="'.$_POST["room"].'" WHERE `employee_id` LIKE "'.$_GET["ZameID"].'"';
    $stmt = $pdo->query($SQLPrikaz);
    unset($stmt);

    $SQLPrikaz = 'DELETE FROM `key` WHERE `key`.`employee` = '.$_GET["ZameID"];
    $stmt = $pdo->query($SQLPrikaz);
    unset($stmt);

    foreach($_POST["klice"] as $roomKlic){
    $SQLPrikaz = 'INSERT INTO `key` (`employee`, `room`) VALUES ("'.$_GET["ZameID"].'", "'.$roomKlic.'")';
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
    <form action="../Zamestnanci/EditZamestnanec.php?ZameID=<?php 
    echo $_GET["ZameID"];
    ?>" method = "POST">
  <label for="name">Jméno</label><br>
  <input type="text" id="name" name="name" value=""><br>
  <label for="surname">Příjmení</label><br>
  <input type="text" id="surname" name="surname" value=""><br>
  <label for="job">Práce</label><br>
  <input type="text" id="job" name="job" value=""><br>
  <label for="wage">plat</label><br>
  <input type="number" id="wage" name="wage" value=""><br>

  <label for="room">Místnost:</label><br>
<select name="room" id="room">

<?php 

$SQLPrikaz = 'SELECT * FROM room ORDER BY name';
$stmt = $pdo -> query($SQLPrikaz);
if($stmt->rowCount() == 0){

}

else{
    $html ="";
    while ($row = $stmt-> fetch()){
       $html.='<option value="'.$row["room_id"].'">'.$row["name"].'</option>';
      
    }
     echo($html);
}
unset($stmt);
?>
</select>


<p>Klíče:</p>
<?php

$SQLPrikaz = 'SELECT * FROM room ORDER BY name';
$stmt = $pdo -> query($SQLPrikaz);
if($stmt->rowCount() == 0){

}

else{
    $html ="";
   
    while ($row = $stmt-> fetch()){
        $html .= '<label>'.$row["name"].'<input type="checkbox" name="klice[]" value="'.$row["room_id"].'"></label><br>';
      
    }
     echo($html);
}
unset($stmt);


?>


<br>
  <input type="submit" value="Edit">
</form>
    </body>
    <br>
    <a href="../Zamestnanci/Zamestnanci.php"> zpět na zaměstnance </a>
</html>