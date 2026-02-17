<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $ruoloSelezionato = $_POST['ruolo'];

    $stmt = $conn->prepare("SELECT * FROM utenti WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $utente = $result->fetch_assoc();

    if ($utente && password_verify($password, $utente['passwordHash']) && $utente['ruolo'] === $ruoloSelezionato) {
        $_SESSION['temp_user'] = $utente;
        if ($ruoloSelezionato === "bibliotecario") {
            header("Location: verifica_codice.php");
        } else {
            header("Location: genera_otp.php");
        }
        exit();
    } else {
        $errore = "Credenziali o ruolo errati";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if (!empty($errore)) echo "<p class='error'>$errore</p>"; ?>
    <form method="POST">
        Email: <input type="email" name="email" required>
        Password: <input type="password" name="password" required>
        Ruolo:
        <select name="ruolo" required>
            <option value="">Seleziona ruolo</option>
            <option value="studente">Studente</option>
            <option value="bibliotecario">Bibliotecario</option>
        </select>
        <button type="submit">Login</button>
    </form>
    <br>
    <p>Non sei registrato? <a href="register.php">Registrati qui</a></p>
</div>
</body>
</html>
