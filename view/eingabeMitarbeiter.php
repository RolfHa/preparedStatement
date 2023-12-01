<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $action  === 'showUpdate' ? 'Daten ändern' : 'Eingabe'; ?>
    </title>
</head>
<body>
<?php include 'view/nav.php'; ?>
<h2>
    <?php
    // ternär Operator (? :)
    echo $action  === 'showUpdate' ? 'Daten ändern' : 'Eingabe';
    ?>
</h2>
<form action="index.php" method="post">
    <input type="hidden" name="area" value="Mitarbeiter">
    <?php
    if ($action === 'showUpdate') {
        ?>
        <input type="hidden" name="id" value="<?php echo $mitarbeiter->getId(); ?>">
        <input type="hidden" name="action" value="update">
        <?php
    } else {
        ?>
        <input type="hidden" name="action" value="insert">
        <?php
    }
    ?>
    <table>
        <tr>
            <td><label for="vorname"> Vorname </label></td>
            <td><input type="text" name="vorname" id="vorname"
                       value="<?php echo $action === 'showUpdate' ? $mitarbeiter->getVorname() : ''; ?>"></td>
        </tr>
        <tr>
            <td><label for="nachname"> Nachname </label></td>
            <td><input type="text" name="nachname" id="nachname"
                       value="<?php echo $action === 'showUpdate' ? $mitarbeiter->getNachname() : ''; ?>"></td>
        </tr>
        <tr>
            <td> <label for="abteilungId"> Abteilung </label></td>
            <td><select name="abteilungId" id="abteilungId">
                    <option value="1">Einkauf</option>
                    <option value="2">Verkauf</option>
                    <option value="3" selected>Marketing</option>
                </select></td>
        </tr>
        <tr>
            <td><input type="submit" value="senden"></td>
            <td></td>
        </tr>
    </table>
</form>
</body>
</html>