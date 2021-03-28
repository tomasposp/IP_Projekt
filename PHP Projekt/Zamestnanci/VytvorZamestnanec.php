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

    if($_POST["name"] != "" && $_POST["surname"] != "" && $_POST["job"] != "" && $_POST["wage"] != "" && $_POST["username"] != "" && $_POST["password"] != ""){
        $admin = $_POST["admin"] ?? 0;
        $SQLPrikaz = 'INSERT INTO `employee`(`name`, `surname`, `job`, `wage`, `room`, `login`, `password`, `admin`) VALUES ("'.$_POST["name"].'", "'.$_POST["surname"].'", "'.$_POST["job"].'", "'.$_POST["wage"].'","'.$_POST["room"].'", "'.$_POST["username"].'", "'.$_POST["password"].'", "'.$admin.'")';
        $stmt = $pdo->query($SQLPrikaz);
        unset($stmt);
        
        $SQLPrikaz = 'SELECT * from employee ORDER BY employee_id DESC';
        $stmt = $pdo->query($SQLPrikaz);
        $ZameID = $stmt->fetch();
        unset($stmt);

        foreach ($_POST["klice"] as $roomIDklic){ 
            $SQLPrikaz = 'INSERT INTO `key` (`employee`, `room`) VALUES ("'.array_values($ZameID)[0].'", "'.$roomIDklic.'")';
            $stmt = $pdo->query($SQLPrikaz);
            unset($stmt);
        }

        echo "<a href='../Zamestnanci/Zamestnanci.php'>zpět na Zaměstnance</a>";
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
    <form action="../Zamestnanci/VytvorZamestnanec.php" method = "POST">
  <label for="name">Jméno</label><br>
  <input type="text" id="name" name="name" value=""><br>
  <label for="surname">Příjmení</label><br>
  <input type="text" id="surname" name="surname" value=""><br>
  <label for="job">Práce</label><br>
  <input type="text" id="job" name="job" value=""><br>
  <label for="wage">plat</label><br>
  <input type="number" id="wage" name="wage" value=""><br>
  <label for="username">username</label><br>
  <input type="text" id="username" name="username" value=""><br>
  <label for="password">password</label><br>
  <input type="password" id="password" name="password" value=""><br>
  <label for="admin">admin</label>
  <input type="checkbox" id="admin" name="admin" value="1"><br><br>


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
  <input type="submit" value="Vytvořit">
</form>
    </body>
</html>