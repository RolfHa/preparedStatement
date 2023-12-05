<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abteilung Liste</title>
</head>
<body>
<?php include 'view/nav.php'; ?>
<h2>Abteilung Liste</h2>

<table style="width:20%">
    <tr>
        <th>Id</th>
        <th>Name</th>

        <th></th>
        <th></th>
    </tr>
    <?php
    for ($i = 0; $i < count($mArr); $i++) {
        ?>
        <tr>
            <td><?php echo $mArr[$i]->getId(); ?></td>
            <td><?php echo $mArr[$i]->getName(); ?></td>

            <td><a href="index.php?action=delete&area=Abteilung&id=<?php echo $mArr[$i]->getId(); ?>">
                    <button>Löschen</button>
                </a></td>
            <td><a href="index.php?action=showUpdate&area=Abteilung&id=<?php echo $mArr[$i]->getId(); ?>">
                    <button>Ändern</button>
                </a></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>