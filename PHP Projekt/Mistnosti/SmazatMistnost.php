<?php
    session_start();
    require_once("../_includes/db.php");
    $pdo = dbConnect();



if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){    
    header("Location: ../Index.php");
    die();
}


else{

    $SQLPrikaz = 'SELECT * FROM `employee` WHERE `employee`.`room` = '.$_GET["RoomID"];
    $stmt = $pdo->query($SQLPrikaz);

       if($stmt->rowCount() == 0){
        
            unset($stmt);
            $SQLPrikaz = 'DELETE FROM `key` WHERE `key`.`room` = '.$_GET["RoomID"];
            $stmt = $pdo->query($SQLPrikaz);
            unset($stmt);
            
            $SQLPrikaz = 'DELETE FROM `room` WHERE `room`.`room_id` = '.$_GET["RoomID"];
            $stmt = $pdo->query($SQLPrikaz);
            echo "Místnost byla úspěšně smazána";
        }
        else{
            echo "Domovská místnost";
        }
}

?>