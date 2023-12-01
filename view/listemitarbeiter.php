<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mitarbeiter Liste</title>
</head>
<body>
<a href="index.php?action=showInsert&area=Mitarbeiter">
    <button>Neuer Mitarbeiter</button>
</a>
<h2>Mitarbeiter Liste</h2>

<table style="width:20%">
    <tr>
        <th>Id</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th></th>
        <th></th>
    </tr>
    <?php
    for ($i = 0; $i < count($mArr); $i++) {
        ?>
        <tr>
            <td><?php echo $mArr[$i]->getId(); ?></td>
            <td><?php echo $mArr[$i]->getVorname(); ?></td>
            <td><?php echo $mArr[$i]->getNachname(); ?></td>
            <td><a href="index.php?action=delete&area=Mitarbeiter&id=<?php echo $mArr[$i]->getId(); ?>">
                    <button>Löschen</button>
                </a></td>
            <td><a href="index.php?action=showUpdate&area=Mitarbeiter&id=<?php echo $mArr[$i]->getId(); ?>">
                    <button>Ändern</button>
                </a></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>