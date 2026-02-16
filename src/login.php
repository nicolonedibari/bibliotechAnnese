<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM utenti WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $utente = $result->fetch_assoc();

    if ($utente && password_verify($password, $utente['passwordHash'])) {

        $_SESSION['temp_user'] = $utente;

        if ($utente['ruolo'] === "bibliotecario") {
            header("Location: verifica_codice.php");
        } else {
            header("Location: genera_otp.php");
        }
        exit();
    } else {
        echo "Credenziali errate";
    }
}
?>

<form method="POST">
Email: <input type="email" name="email" required><br>
Password: <input type="password" name="password" required><br>
<button type="submit">Login</button>
</form>
