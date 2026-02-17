<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $otpInserito = $_POST['otp'];
    $idSessione = $_SESSION['idSessione'];

    $stmt = $conn->prepare("SELECT * FROM sessioni WHERE idSessione=?");
    $stmt->bind_param("i", $idSessione);
    $stmt->execute();
    $result = $stmt->get_result();
    $sessione = $result->fetch_assoc();

    if ($sessione && $sessione['OTP'] == $otpInserito && $sessione['scadenzaOTP'] > date("Y-m-d H:i:s")) {

        $_SESSION['idUtente'] = $_SESSION['temp_user']['idUtente'];
        $_SESSION['nome'] = $_SESSION['temp_user']['nome'];
        $_SESSION['cognome'] = $_SESSION['temp_user']['cognome'];
        $_SESSION['email'] = $_SESSION['temp_user']['email'];
        $_SESSION['ruolo'] = $_SESSION['temp_user']['ruolo'];
        $_SESSION['loginTime'] = date("Y-m-d H:i:s");
        $_SESSION['2fa_verificato'] = true;

        unset($_SESSION['temp_user']);

        header("Location: index.php");
        exit();
    } else {
        echo "OTP errato o scaduto";
    }
}
?>

<form method="POST">
Inserisci OTP:
<input type="text" name="otp" required>
<button type="submit">Verifica</button>
</form>
