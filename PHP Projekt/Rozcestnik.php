<?php
session_start();
if(!array_key_exists("username", $_SESSION)){
    
    header("Location: /Index.php");
    die();

}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Rozcestník</title>
</head>
<body class = "container">
<h1> Rozcestnik </h1>
<h2> <a href="../Mistnosti/Mistnosti.php"> Seznam Místností </a></h2>
<h2> <a href="../Zamestnanci/Zamestnanci.php"> Seznam Zaměstnanců </a></h2>
<h2> <a href="ZmenaHesla.php"> Změna hesla </a></h2>
<h2> <a href="../Zamestnanci/VytvorZamestnanec.php"> vytvořit zaměstnance </a></h2>
<h2> <a href="./Mistnosti/VytvorMistnost.php"> vytvořit místnost </a></h2>
<h2> <a href="Odhlaseni.php"> Odhlásit se </a></h2>

</body>
</html>