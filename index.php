<?php
try {
    include 'config.php';
    spl_autoload_register(function ($className) {
        include 'class/' . $className . '.php';
    });

//echo '<pre>';
//print_r($_REQUEST);
//echo '</pre>';

// Variablenempfang
// Null Coalescing Operator (??)
    $action = ($_REQUEST['action']) ?? ''; // Startseite
    $id = ($_REQUEST['id']) ?? '';
    $area = ($_REQUEST['area']) ?? ''; // Objekte aus welcher Klasse: Klassenname
    $vorname = ($_POST['vorname']) ?? '';
    $nachname = ($_POST['nachname']) ?? '';
    $name = ($_POST['name']) ?? '';
    $abteilungId = ($_POST['abteilungId']) ?? '';
    $passwort = ($_POST['passwort']) ?? '';

    // Authentifizieren
    session_start();
    if (isset($_SESSION['userId'])) {
        $u = new User();
        $userId = $_SESSION['userId'];
        $user = $u->getObjectById($userId);

    } else {
        if ($action === 'checkLogin') {
            $view = User::checkLogin($name, $passwort);
            if (isset($_SESSION['userId'])) {
                $u = new User();
                $user = $u->getObjectById($_SESSION['userId']);

                $area = 'mitarbeiter';
                $view = 'liste';
                $m = new Mitarbeiter();
                $mArr = $m->getAllAsObjects();
            }
        } else {
            $view = 'login';
        }

    }

// index.php ist der controllecho $area;er der kontrolliert
// was angezeigt bzw. was ausgeführt werden soll
    if ($action === 'showList') {
        if ($area === 'Mitarbeiter') {
            $m = new Mitarbeiter();
            $mArr = $m->getAllAsObjects();
            $view = 'liste';
        } elseif ($area === 'Abteilung') {
            $m = new Abteilung();
            $mArr = $m->getAllAsObjects();

            $view = 'liste';
        }
    } elseif ($action === 'showInsert') {
        if ($area === 'Mitarbeiter') {
            $a = new Abteilung();

            $view = 'eingabe';
        } elseif ($area === 'Abteilung') {

            $view = 'eingabe';
        }
    } elseif ($action === 'insert') {
        if ($area === 'Mitarbeiter') {
            $m = new Mitarbeiter();
            $m->createObject($vorname, $nachname, $abteilungId);
            $mArr = $m->getAllAsObjects();

            $view = 'liste';
        } elseif ($area === 'Abteilung') {
            $m = new Abteilung();
            $m->createObject($name);
            $mArr = $m->getAllAsObjects();

            $view = 'liste';
        }
    } elseif ($action === 'showUpdate') {
        if ($area === 'Mitarbeiter') {
            $m = new Mitarbeiter();
            $mitarbeiter = $m->getObjectById($id);
            print_r($mitarbeiter);
            $a = new Abteilung();

            $view = 'eingabe';
        } elseif ($area === 'Abteilung') {
            $m = new Abteilung();
            $abteilung = $m->getObjectById($id);

            $view = 'eingabe';
        }
    } elseif ($action === 'update') {
        if ($area === 'Mitarbeiter') {
            $m = new Mitarbeiter($id, $vorname, $nachname, $abteilungId);
            $m->updateObject(); // in Tabelle festschreiben
            $mArr = $m->getAllAsObjects();

            $view = 'liste';
        } elseif ($area === 'Abteilung') {
            $m = new Abteilung($id, $name);
            $m->updateObject(); // in Tabelle festschreiben
            $mArr = $m->getAllAsObjects();

            $view = 'liste';
        }
    } elseif ($action === 'delete') {
        if ($area === 'Mitarbeiter') {
            $m = new Mitarbeiter();
            $m->deleteObject($id);
            $mArr = $m->getAllAsObjects();

            $view = 'liste';
        } elseif ($area === 'Abteilung') {
            $m = new Abteilung();
            $m->deleteObject($id);
            $mArr = $m->getAllAsObjects();

            $view = 'liste';
        }
    } elseif ($action === 'ausloggen') {
        unset($_SESSION['userId']);// session beenden
        header("Location: http://localhost/preparedStatementFinn"); // Weiterleitung auf Startseite
    } else {
        // wird gebraucht, wenn ein eingeloggter user einen 2. Tab im Browser öffnet
        if (isset($user) && $user instanceof User) {

            $m = new Mitarbeiter();
            $mArr = $m->getAllAsObjects();
            $area = 'Mitarbeiter';
            $view = 'liste';
        }
    }
    // Abfangen, falls user (Nicht-Admin) versucht url mit GET-Variablen zu editieren
    if (isset($user) && $user->getRolle() !== 'admin' && $area === 'Abteilung') {
        unset($_SESSION['userId']);// session beenden
        header("Location: http://localhost/preparedStatementFinn"); // Weiterleitung auf Startseite
    }
    // zentrales include für alle Fallunterscheidungen
    include PATH_TO_VIEW . '/' . $view . $area . '.php';

} catch (Exception $e) {
    if (substr($e->getMessage(), 0, 6) === 'Fehler') {
        $message = $e->getMessage();
    } else {
        // Die Fehlermeldung mit Datum wird im log.txt-File hinterlegt
        // Reihenfolge: aktuellste Datum oben
        $dt = new DateTime();
        $logString = $dt->format('d.m.Y H:i:s') . ' ' . $e->getMessage();
        file_put_contents('log/log.txt',
            $logString . PHP_EOL . file_get_contents('log/log.txt'));
        $message = 'Es ist ein Fehler aufgetreten, der Admin ist informiert.';
    }
    include PATH_TO_VIEW . '/fehler.php';
}
?>

