<?php
session_start();
    require_once("../_includes/db.php");
    $pdo = dbConnect();

if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){    
    header("Location: ../Index.php");
    die();
}


else{


    $SQLPrikaz = 'DELETE FROM `key` WHERE `key`.`employee` = '.$_GET["ZameID"];
    $stmt = $pdo->query($SQLPrikaz);
    unset($stmt);
    
    $SQLPrikaz = 'DELETE FROM `employee` WHERE `employee`.`employee_id` = '.$_GET["ZameID"];
    $stmt = $pdo->query($SQLPrikaz);

    echo "Zaměstnanec byl úspěšně smazán";

}
?>