<?php
require_once "db.php";

$idSessione = $_SESSION['idSessione'];

$stmt = $conn->prepare("UPDATE sessioni SET dataLogout=NOW() WHERE idSessione=?");
$stmt->bind_param("i", $idSessione);
$stmt->execute();

session_destroy();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Logout completato</h2>
    <p>Hai effettuato il logout con successo.</p>
    <a href="login.php">Torna al login</a>
</div>
</body>
</html>
