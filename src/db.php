<?php
session_start();

$conn = new mysqli("db", "myuser", "mypassword", "biblioteca");

if ($conn->connect_error) {
    die("Errore connessione DB");
} else {
    //echo "Connessione DB riuscita";
}

define("CODICE_BIBLIOTECARIO", "BIBLIO2026");
define("MAX_PRESTITI", 3);
?>
