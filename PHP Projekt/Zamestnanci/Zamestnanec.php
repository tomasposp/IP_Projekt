<?php
require_once("../_includes/db.php");
$zamestnanecID = (int) ($_GET["ZameID"] ?? 0);

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
    <title><?php
        $pdo = dbConnect();
        $stmt = $pdo -> prepare("SELECT * FROM employee WHERE employee_id=?");
        $stmt->execute([$zamestnanecID]);


        if ($stmt->rowCount()== 0){
            echo "Not found";
        }
        else{
            $row = $stmt-> fetch();
            echo "Zaměstnanec ".$row['name']." ".$row['surname'];
        }

        ?></title>
</head>
<body class = "container">
<?php
$pdo = dbConnect();

$stmt = $pdo->prepare('SELECT employee.name, employee.surname, employee.job, employee.room, employee.wage, room.name AS "r_name" FROM employee, room WHERE employee_id=? AND room.room_id = employee.room');
$stmt->execute([$zamestnanecID]);
if ($stmt->rowCount() == 0){
    echo "Missing Data";
}
else{
    $html = "<h1> Zamestnanec $zamestnanecID</h1>";
    $row = $stmt->fetch();

    $html .= "<dl>";

    $html .= "<dt>Jméno</dt>";
    $html .= "<dd>".htmlspecialchars($row['name'])."</dd>";

    $html .= "<dt>Přijmení</dt>";
    $html .= "<dd>".htmlspecialchars($row['surname'])."</dd>";

    $html .= "<dt>Práce</dt>";
    $html .= "<dd>".htmlspecialchars($row['job'])."</dd>";

    $html .= "<dt>Mzda</dt>";
    $html .= "<dd>".htmlspecialchars($row['wage'])."</dd>";

    $html .= "<dt>Místnost</dt>";
    $html .= "<td><a href='../Mistnosti/Mistnost.php?RoomID={$row['room']}'>".htmlspecialchars($row['r_name'])."</a></td>";


    $html .= "<dt> Klíče </dt>";
    $stmt2 = $pdo -> prepare("SELECT key.room, room_id, name, employee FROM `key`, room WHERE employee=? AND room_id = key.room");
    $stmt2 -> execute([$zamestnanecID]);

    foreach ($stmt2 as $row2){
        $html .= "<dd><a href='../Mistnosti/Mistnost.php?RoomID={$row2['room_id']}'>".htmlspecialchars($row2['name'])."</a></dd>";
    }

    $html .= "<dl>";

    echo $html;
}
unset($stmt)
?>
<br>
<a href="Zamestnanci.php"> zpět na seznam zaměstnanců </a><br>
<a href="../Rozcestnik.php"> zpět na rozcestník </a>
</body>
</html>
