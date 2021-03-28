<?php
require_once("../_includes/db.php");
$pdo = dbConnect();

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
        <title>Zamestnanci</title>
    </head>
    <body class = "container">
    <h1>Seznam zaměstnanců</h1>
<?php

$razeni = (int) ($_GET["razeni"] ?? 0);

$razeniSQLPrikaz = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS r_name, room.phone FROM employee, room WHERE room.room_id = employee.room';
if (isset($razeni) && $razeni != 0) {
    if ($razeni == 1){
        $razeniSQLPrikaz = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS r_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY name DESC';
    }
    else if ($razeni == 2){
        $razeniSQLPrikaz = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS r_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY r_name';
    }
    else if ($razeni == 3){
        $razeniSQLPrikaz = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS r_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY r_name DESC';
    }
    else if ($razeni == 4){
        $razeniSQLPrikaz = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS r_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY phone';
    }
    else if ($razeni == 5){
        $razeniSQLPrikaz = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS r_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY phone DESC';
    }
    else if ($razeni == 6){
        $razeniSQLPrikaz = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS r_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY job';
    }
    else if ($razeni == 7){
        $razeniSQLPrikaz = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS r_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY job DESC';
    }
}

$stmt = $pdo->query($razeniSQLPrikaz);

if ($stmt->rowCount() == 0) {
    echo "Missing Data";
}
else{
    $html = "<table class = 'table'>";
    $html .= "<thead>";
    $html .= "<th>Jméno</th>";
    $html .= "<th>Místnost</th>";
    $html .= "<th>Telefon</th>";
    $html .= "<th>Pozice</th>";
    if($_SESSION["admin"]==1){
        $html .= "<th></th>";
        $html .= "<th></th>";
    }
    
    $html .= "</thead>";

    $html .= "<tbody>";

    while ($row = $stmt->fetch()) {
        $html .= "<tr>";
        $html .= "<td><a href='Zamestnanec.php?ZameID={$row['employee_id']}'>".htmlspecialchars($row['name'])." ".htmlspecialchars($row['surname'])."</a></td>";
        $html .= "<td>".htmlspecialchars($row['r_name'])."</td>";
        $html .= "<td>".htmlspecialchars($row['phone'])."</td>";
        $html .= "<td>".htmlspecialchars($row['job'])."</td>";        
        if($_SESSION["admin"]==1){
            $html .= "<td><a href ='EditZamestnanec.php?ZameID=".$row['employee_id']."'>edit</a></td>";
            $html .= "<td><a href ='SmazatZamestnanec.php?ZameID=".$row['employee_id']."'>Smazat</a></td>";
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