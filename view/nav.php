<a href="index.php?action=showList&area=Mitarbeiter">
    <button>Liste Mitarbeiter</button>
</a>
<a href="index.php?action=showInsert&area=Mitarbeiter">
    <button>Neuer Mitarbeiter</button>
</a>
<?php
if ($user->getRolle() === 'admin'){
?>
<a href="index.php?action=showList&area=Abteilung">
    <button>Liste Abteilung</button>
</a>
<a href="index.php?action=showInsert&area=Abteilung">
    <button>Neue Abteilung</button>
</a>
<?php
}
?>