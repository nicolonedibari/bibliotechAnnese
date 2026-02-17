<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ruolo = $_POST['ruolo'];

    $check = $conn->prepare("SELECT idUtente FROM utenti WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $errore = "Email già registrata.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO utenti (nome, cognome, email, passwordHash, ruolo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $cognome, $email, $passwordHash, $ruolo);
        if ($stmt->execute()) {
            $successo = "Registrazione completata!";
        } else {
            $errore = "Errore nella registrazione.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Registrazione</h2>
    <?php 
    if (!empty($errore)) echo "<p class='error'>$errore</p>";
    if (!empty($successo)) echo "<p style='color:green;'>$successo <a href='login.php'>Vai al login</a></p>";
    ?>
    <form method="POST">
        Nome: <input type="text" name="nome" required>
        Cognome: <input type="text" name="cognome" required>
        Email: <input type="email" name="email" required>
        Password: <input type="password" name="password" required>
        Ruolo:
        <select name="ruolo" required>
            <option value="">Seleziona ruolo</option>
            <option value="studente">Studente</option>
            <option value="bibliotecario">Bibliotecario</option>
        </select>
        <button type="submit">Registrati</button>
    </form>
    <br>
    <a href="login.php">Hai già un account? Login</a>
</div>
</body>
</html>
