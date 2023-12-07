<?php
include 'config.php';
include 'class/Dbconn.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Nehmen wir an, dass das Formular ein POST-Formular ist
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $passwort = $_POST['passwort'];

    // Vor der Verwendung von Benutzereingaben bereinigen und absichern
   // $benutzername = mysqli_real_escape_string($conn, $benutzername);
    $pdo = Dbconn::getConn();
    $stmt = $pdo->prepare("SELECT id, name, passwort, rolle FROM user WHERE name=:name");
    $stmt->bindParam('name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $benutzer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (is_array($benutzer)) {

        $hashed_password = $benutzer['passwort'];

        // Überprüfe das Passwort mit password_verify()
        if (password_verify($passwort, $hashed_password)) {
            // Passwort ist korrekt, Authentifizierung erfolgreich
            echo "Erfolgreich authentifiziert!";
            // Hier könntest du eine Session starten oder andere Aktionen ausführen
        } else {
            // Passwort ist inkorrekt, Authentifizierung fehlgeschlagen
            echo "Ungültige Anmeldeinformationen!";
        }
    } else {
        // Benutzer nicht gefunden
        echo "Benutzer nicht gefunden!";
    }
}
