<?php
require_once "db.php";

if ($_SESSION['ruolo'] !== "bibliotecario") {
    header("Location: login.php");
    exit();
}

$result = $conn->query("
SELECT prestiti.idPrestito, libri.titolo, utenti.nome, prestiti.dataInizio
FROM prestiti
JOIN libri ON prestiti.idLibro = libri.idLibro
JOIN utenti ON prestiti.idUtente = utenti.idUtente
WHERE prestiti.dataRestituzione IS NULL
");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Restituzioni</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Restituzioni Libri</h2>
    <?php while ($row = $result->fetch_assoc()){ ?>
        <div class="prestito">
            <?= htmlspecialchars($row['titolo']) ?> - <?= htmlspecialchars($row['nome']) ?> - <?= $row['dataInizio'] ?>
            <a href="restituisci.php?id=<?= $row['idPrestito'] ?>">RESTITUISCI</a>
        </div>
    <?php } ?>
    <br>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
