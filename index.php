<?php
include 'config.php';
spl_autoload_register(function ($className){
    include 'class/' . $className . '.php';
});

//echo '<pre>';
//print_r($_REQUEST);
//echo '</pre>';

// Variablenempfang
// Null Coalescing Operator (??)
$action = ($_REQUEST['action']) ?? 'showList'; // Startseite
$id = ($_REQUEST['id']) ?? '';
$area = ($_REQUEST['area']) ?? 'Mitarbeiter'; // Objekte aus welcher Klasse: Klassenname
$vorname = ($_POST['vorname']) ?? '';
$nachname = ($_POST['nachname']) ?? '';
$name = ($_POST['name']) ?? '';
$abteilungId = ($_POST['abteilungId']) ?? '';


// index.php ist der controller der kontrolliert
// was angezeigt bzw. was ausgeführt werden soll
if ($action === 'showList') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter();
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/liste'.$area.'.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung();
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/liste'.$area.'.php';
    }
} elseif ($action === 'showInsert') {
    if ($area === 'Mitarbeiter') {
        $a = new Abteilung();
        include PATH_TO_VIEW .'/eingabe'.$area.'.php';
    } elseif ($area === 'Abteilung'){
        include PATH_TO_VIEW .'/eingabe'.$area.'.php';
    }
} elseif ($action === 'insert') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter();
        $m->createObject($vorname, $nachname, $abteilungId);
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/liste'.$area.'.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung();
        $m->createObject($name);
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/liste'.$area.'.php';
    }
} elseif ($action === 'showUpdate') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter();
        $mitarbeiter = $m->getObjectById($id);
        print_r($mitarbeiter);
        $a = new Abteilung();
        include PATH_TO_VIEW .'/eingabe'.$area.'.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung();
        $abteilung = $m->getObjectById($id);
        include PATH_TO_VIEW .'/eingabe'.$area.'.php';
    }
} elseif ($action === 'update') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter($id, $vorname, $nachname, $abteilungId);
        $m->updateObject(); // in Tabelle festschreiben
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/liste'.$area.'.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung($id, $name);
        $m->updateObject(); // in Tabelle festschreiben
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/liste'.$area.'.php';
    }
} elseif ($action === 'delete') {
    if ($area === 'Mitarbeiter') {
        $m = new Mitarbeiter();
        $m->deleteObject($id);
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/liste'.$area.'.php';
    } elseif ($area === 'Abteilung'){
        $m = new Abteilung();
        $m->deleteObject($id);
        $mArr = $m->getAllAsObjects();
        include PATH_TO_VIEW .'/liste'.$area.'.php';
    }
} else {
    $message = 'Datei nicht gefunden: 404';
    include PATH_TO_VIEW .'/fehler.php';
}

?>

