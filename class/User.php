<?php

class User
{

    public static function checkLogin(string $name, string $passwort): string
    {
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
                $_SESSION['userId'] = $benutzer['id'];
                // Hier könntest du eine Session starten oder andere Aktionen ausführen
                $view = 'liste';
            } else {
                // Passwort ist inkorrekt, Authentifizierung fehlgeschlagen
                echo "Ungültige Anmeldeinformationen!";
                $view = 'login';
            }
        } else {
            // Benutzer nicht gefunden
            echo "Benutzer nicht gefunden!";
            $view = 'login';
        }
        return $view;
    }
}