<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST['codice'] === CODICE_BIBLIOTECARIO) {
        $_SESSION['codice_bibliotecario_verificato'] = true;
        header("Location: genera_otp.php");
        exit();
    } else {
        echo "Codice bibliotecario errato";
    }
}
?>

<form method="POST">
Codice Bibliotecario:
<input type="text" name="codice" required>
<button type="submit">Verifica</button>
</form>
