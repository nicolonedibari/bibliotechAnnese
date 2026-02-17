<?php
require_once "db.php";

$idSessione = $_SESSION['idSessione'];

$stmt = $conn->prepare("UPDATE sessioni SET dataLogout=NOW() WHERE idSessione=?");
$stmt->bind_param("i", $idSessione);
$stmt->execute();

$_SESSION = [];

//cancella il cookie della sessione
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(),'',time() - 42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
}

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
