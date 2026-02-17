<?php
require_once "db.php";

if (!isset($_SESSION['idUtente']) || $_SESSION['ruolo'] !== "studente") {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT * FROM libri");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Catalogo Libri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Catalogo Libri</h2>
    <?php while ($libro = $result->fetch_assoc()){ ?>
        <div class="libro">
            <h3><?= htmlspecialchars($libro['titolo']) ?></h3>
            Disponibili: <?= $libro['copieDisponibili'] ?><br>
            <?php if ($libro['copieDisponibili'] > 0) { ?>
                <a href="prendi_prestito.php?id=<?= $libro['idLibro'] ?>">PRENDI IN PRESTITO</a>
            <?php } ?>
        </div>
    <?php } ?>
    <a href="prestiti.php">I miei prestiti</a><br>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
