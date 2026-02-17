<?php
require_once "db.php";

$idPrestito = $_GET['id'];

$conn->begin_transaction();

$conn->query("UPDATE prestiti SET dataRestituzione=NOW() WHERE idPrestito=$idPrestito");

$conn->query("
UPDATE libri 
SET copieDisponibili = copieDisponibili + 1 
WHERE idLibro = (SELECT idLibro FROM prestiti WHERE idPrestito=$idPrestito)
");

$conn->commit();

header("Location: gestione_restituzioni.php");
?>