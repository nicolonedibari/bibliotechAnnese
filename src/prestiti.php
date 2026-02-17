<?php
require_once "db.php";

$idUtente = $_SESSION['idUtente'];

$stmt = $conn->prepare("
SELECT libri.titolo, prestiti.dataInizio 
FROM prestiti 
JOIN libri ON prestiti.idLibro = libri.idLibro
WHERE prestiti.idUtente=? AND dataRestituzione IS NULL
");
$stmt->bind_param("i", $idUtente);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>I miei prestiti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>I miei prestiti</h2>
    <?php while ($row = $result->fetch_assoc()){ ?>
        <div class="prestito">
            <?= htmlspecialchars($row['titolo']) ?> - <?= $row['dataInizio'] ?>
        </div>
    <?php } ?>
    <br>
    <a href="libri.php">Torna al catalogo</a>
</div>
</body>
</html>
