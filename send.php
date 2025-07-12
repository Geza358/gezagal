<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variablen aus Formular auslesen & bereinigen
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Validierung
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Ungültige Eingaben
        http_response_code(400);
        echo "Bitte füllen Sie alle Felder korrekt aus.";
        exit;
    }

    // Empfänger-Adresse (deine E-Mail)
    $recipient = "fabian9821@t-online.de";

    // Betreff der Mail
    $subject = "Neue Nachricht von $name";

    // Inhalt der Mail
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Nachricht:\n$message\n";

    // Zusätzliche Header
    $email_headers = "From: $name <$email>";

    // Mail senden
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Danke! Ihre Nachricht wurde gesendet.";
    } else {
        http_response_code(500);
        echo "Entschuldigung, beim Versenden der Nachricht ist ein Fehler aufgetreten.";
    }

} else {
    // Nicht POST-Anfrage blockieren
    http_response_code(403);
    echo "Es gab ein Problem mit Ihrer Einsendung, bitte versuchen Sie es erneut.";
}
?>
