<?php
require_once "db.php";

if (!isset($_SESSION['temp_user'])) {
    header("Location: login.php");
    exit();
}

$utente = $_SESSION['temp_user'];
function mandaOtp(string $toEmail, string $otp): bool {
    $sock = @fsockopen('mailpit', 1025, $errno, $errstr, 5);
    if (!$sock) return false;

    $read  = fn() => fgets($sock, 512);
    $write = fn(string $cmd) => fwrite($sock, $cmd . "\r\n");

    $read();
    $write("EHLO bibliotech.local");
    while (($line = $read()) && substr($line, 3, 1) === '-');

    $write("MAIL FROM:<noreply@bibliotech.local>"); 
    $read();

    $write("RCPT TO:<{$toEmail}>");                
    $read();

    $write("DATA");                                
    $read();

    $message  = "From: BiblioTech <noreply@bibliotech.local>\r\n";
    $message .= "To: {$toEmail}\r\n";
    $message .= "Subject: Codice OTP BiblioTech\r\n";
    $message .= "MIME-Version: 1.0\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $message .= "Il tuo codice OTP è: {$otp}\r\n";
    $message .= "Valido per 5 minuti.\r\n";

    $write($message . ".");
    $read();

    $write("QUIT");
    fclose($sock);

    return true;
}

$otp = (string) rand(100000, 999999);
$scadenzaOTP = date("Y-m-d H:i:s", strtotime("+5 minutes"));
$inizio = date("Y-m-d H:i:s");
$scadenza = date("Y-m-d H:i:s", strtotime("+1 hour"));

$stmt = $conn->prepare("
    INSERT INTO sessioni (idUtente, inizio, scadenza, OTP, scadenzaOTP)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("issss", $utente['idUtente'],$inizio, $scadenza, $otp, $scadenzaOTP);

if ($stmt->execute()) {

    $_SESSION['idSessione'] = $conn->insert_id;

    if (mandaOtp($utente['email'], $otp)) {
        header("Location: verifica_otp.php");
        exit();
    } else {
        echo "Errore: Mailpit non raggiungibile. Verifica che il container sia attivo.";
    }

} else {
    echo "Errore nella creazione della sessione OTP.";
}
?>
