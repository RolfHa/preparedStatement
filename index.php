<?php
include 'config.php';
include 'class/Dbconn.php';
include 'class/Abteilung.php';
include 'class/Mitarbeiter.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';


// Variablenempfang
// Null Coalescing Operator (??)
$action = ($_REQUEST['action']) ?? 'showList'; // Startseite
$id = ($_REQUEST['id']) ?? '';
$area = ($_REQUEST['area']) ?? 'Mitarbeiter'; // Objekte aus welcher Klasse: Klassenname
$vorname = ($_POST['vorname']) ?? '';
$nachname = ($_POST['nachname']) ?? '';
$name = ($_POST['name']) ?? '';

// index.php ist der controller der kontrolliert
// was angezeigt bzw. was ausgeführt werden soll
if ($action === 'showList') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter();
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/listemitarbeiter.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung();
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/listeabteilung.php';
    }
} elseif ($action === 'showInsert') {
    if ($area === 'Mitarbeiter') {
        include PATH_TO_VIEW .'/eingabemitarbeiter.php';
    } elseif ($area === 'Abteilung'){
        include PATH_TO_VIEW .'/eingabeabteilung.php';
    }
} elseif ($action === 'insert') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter();
        $m->createObject($vorname, $nachname);
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/listemitarbeiter.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung();
        $m->createObject($name);
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/listeabteilung.php';
    }
} elseif ($action === 'showUpdate') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter();
        $mitarbeiter = $m->getObjectById($id);
        include PATH_TO_VIEW .'/eingabemitarbeiter.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung();
        $abteilung = $m->getObjectById($id);
        include PATH_TO_VIEW .'/eingabeabteilung.php';
    }
} elseif ($action === 'update') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter($id, $vorname, $nachname);
        $m->updateObject(); // in Tabelle festschreiben
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/listemitarbeiter.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung($id, $name);
        $m->updateObject(); // in Tabelle festschreiben
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/listeabteilung.php';
    }
} elseif ($action === 'delete') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter();
        $m->deleteObject($id);
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/listemitarbeiter.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung();
        $m->deleteObject($id);
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/listeabteilung.php';
    }
} else {
    $message = 'Datei nicht gefunden: 404';
    include PATH_TO_VIEW .'/fehler.php';
}

?>

