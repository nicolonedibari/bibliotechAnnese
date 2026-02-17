<?php
require_once "db.php";

$idUtente = $_SESSION['idUtente'];
$idLibro = $_GET['id'];

$check = $conn->prepare("SELECT COUNT(*) as totale FROM prestiti WHERE idUtente=? AND dataRestituzione IS NULL");
$check->bind_param("i", $idUtente);
$check->execute();
$res = $check->get_result()->fetch_assoc();

if ($res['totale'] >= MAX_PRESTITI) {
    die("Hai raggiunto il limite massimo di prestiti.");
}

$conn->begin_transaction();

$conn->query("UPDATE libri SET copieDisponibili = copieDisponibili - 1 WHERE idLibro=$idLibro AND copieDisponibili > 0");

$inizio = date("Y-m-d H:i:s");
$scadenza = date("Y-m-d H:i:s", strtotime("+30 days"));

$stmt = $conn->prepare("INSERT INTO prestiti (idUtente, idLibro, dataInizio, dataScadenza) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $idUtente, $idLibro, $inizio, $scadenza);
$stmt->execute();

$conn->commit();

header("Location: libri.php");
