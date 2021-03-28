<?php 

session_start(); 
$_SESSION = []; 
session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo "Byl jste odhlášen ze systému";
        ?>
        <br>
        <a href="Index.php"> zpět na přihlášení </a>
    </body>
</html>