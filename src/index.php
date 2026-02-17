<?php
require_once "db.php";

if (!isset($_SESSION['idUtente']) || !$_SESSION['2fa_verificato']) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['ruolo'] === "bibliotecario") {
    header("Location: gestione_restituzioni.php");
} else {
    header("Location: libri.php");
}
exit();

?>