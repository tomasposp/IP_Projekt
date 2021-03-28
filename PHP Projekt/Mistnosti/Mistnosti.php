<?php
require_once("../_includes/db.php");


session_start();
if(!array_key_exists("username", $_SESSION)){
    
    header("Location: ../Index.php");
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
    <title>Seznam místností</title>
</head>
<body class = "container">
<h1>Seznam Místností</h1>
<?php

$pdo = dbConnect();
$razeni = (int) ($_GET["razeni"] ?? 0);

$razeniSQLPrikaz = 'SELECT * FROM room ORDER BY name';
if (isset($razeni) && $razeni != 0) {
    if ($razeni == 1){
        $razeniSQLPrikaz = 'SELECT * FROM room ORDER BY name DESC';
    }
    else if ($razeni == 2){
        $razeniSQLPrikaz = 'SELECT * FROM room ORDER BY no';
    }
    else if ($razeni == 3){
        $razeniSQLPrikaz = 'SELECT * FROM room ORDER BY no DESC';
    }
    else if ($razeni == 4){
        $razeniSQLPrikaz = 'SELECT * FROM room ORDER BY phone';
    }
    else if ($razeni == 5){
        $razeniSQLPrikaz = 'SELECT * FROM room ORDER BY phone DESC';
    }
}

$stmt = $pdo->query($razeniSQLPrikaz);

if($stmt->rowCount() == 0){
    echo "Missing Data";
}
else{
    $html = "<table class = 'table'>";
    $html .= "<thead>";
    $html .= "<th>Název <a href=Mistnosti.php?razeni=0>🢃</a> <a href=Mistnosti.php?razeni=1>🢁</a></th>";
    $html .= "<th>Číslo <a href=Mistnosti.php?razeni=2>🢃</a> <a href=Mistnosti.php?razeni=3>🢁</a></th>";
    $html .= "<th>Telefon <a href=Mistnosti.php?razeni=4>🢃</a> <a href=Mistnosti.php?razeni=5>🢁</a></th>";
    if($_SESSION["admin"]==1){
        $html .= "<th></th>";
        $html .= "<th></th>";
    }
    $html .= "</thead>";
    $html .= "<tbody>";

    while ($row = $stmt->fetch()) {
        $html .= "<tr>";
        $html .= "<td><a href='Mistnost.php?RoomID={$row['room_id']}'>".htmlspecialchars($row['name'])."</a></td>";
        $html .= "<td>".htmlspecialchars($row['no'])."</td>";
        $html .= "<td>".htmlspecialchars($row['phone'])."</td>";
        if($_SESSION["admin"]==1){
            $html .= "<td><a href ='EditMistnost.php?RoomID=".$row['room_id']."'>edit</a></td>";
            $html .= "<td><a href ='SmazatMistnost.php?RoomID=".$row['room_id']."'>Smazat</a></td>";
        }
        
        $html .= "</tr>";
    }
    $html .= "</table>";



    echo $html;
}
unset($html);
?>
<br>
<a href="../Rozcestnik.php"> zpět na rozcestník </a>
</body>
</html>
