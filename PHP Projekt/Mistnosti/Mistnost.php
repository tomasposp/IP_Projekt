<?php

require_once("../_includes/db.php");
$roomID = (int) ($_GET["RoomID"] ?? 0);

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
    <title><?php
        $pdo = dbConnect();
        $stmt = $pdo -> prepare("SELECT * FROM room WHERE room_id=?");
        $stmt->execute([$roomID]);
        if ($stmt->rowCount()== 0){
            echo "Not found";
        }
        else{
            $row = $stmt-> fetch();
            echo "Místnost ".$row['name'];
        }
        ?></title>
</head>
<body class = "container">
<?php
$pdo = dbConnect();

$stmt = $pdo->prepare("SELECT * FROM room WHERE room_id=?");
$stmt->execute([$roomID]);
if ($stmt->rowCount() == 0){
    echo "Missing Data";
}
else{
    $html = "<h1> Místnost $roomID</h1>";
    $row = $stmt->fetch();

    $html .= "<dl>";

    $html .= "<dt>Číslo</dt>";
    $html .= "<dd>".htmlspecialchars($row['no'])."</dd>";

    $html .= "<dt>Název</dt>";
    $html .= "<dd>".htmlspecialchars($row['name'])."</dd>";

    $html .= "<dt>Telefon</dt>";
    $html .= "<dd>".htmlspecialchars($row['phone'])."</dd>";

    $html .= "<dl>";


    $mzda = 0;
    $pocetlid = 0;
    $html .= "<dt> Lidé </dt>";
    $stmt2 = $pdo -> prepare("SELECT employee.name, employee.surname, employee.employee_id, employee.room, employee.wage FROM employee JOIN room ON room_id =? WHERE room.room_id = employee.room");
    $stmt2 -> execute([$roomID]);
        foreach ($stmt2 as $row2){
            $html .= "<dd><a href='../Zamestnanci/Zamestnanec.php?ZameID={$row2['employee_id']}'>".($row2['name'])." ".($row2['surname'])."</a></dd>";
            $pocetlid++;
            $mzda = $mzda + $row2['wage'];

        }

    $html .= "<dt>Průměrná mzda </dt>";
        if ($pocetlid == 0){
            echo "Nejsou zde lidi";
        }
        else{
            $html .= "<dd>".($mzda/$pocetlid)."</dd>";
        }




    $html .= "<dt> Klíče </dt>";
    $stmt3 = $pdo -> prepare("SELECT key.employee, key.room, employee.name, employee.surname FROM `key`, employee WHERE key.room = ? AND employee.employee_id = key.employee");
    $stmt3 -> execute([$roomID]);

    foreach ($stmt3 as $row3){
        $html .= "<dd><a href='../Zamestnanci/Zamestnanec.php?ZameID={$row3['employee']}'>".htmlspecialchars($row3['surname'])."</a></dd>";
    }

    echo $html;
}

unset($stmt)
?>
<br>
<a href="Mistnosti.php"> zpět na seznam místností </a> <br>
<a href="../Rozcestnik.php"> zpět na rozcestník </a>
</body>
</html>
