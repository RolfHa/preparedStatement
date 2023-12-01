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
<h2>
    <?php
    // ternär Operator (? :)
    echo $action  === 'showUpdate' ? 'Daten ändern' : 'Eingabe';
    ?>
</h2>
<form action="index.php" method="post">
    <input type="hidden" name="area" value="Abteilung">
    <?php
    if ($action === 'showUpdate') {
        ?>
        <input type="hidden" name="id" value="<?php echo $abteilung->getId(); ?>">
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
            <td><label for="name"> Abteilung </label></td>
            <td><input type="text" name="name" id="name"
                       value="<?php echo $action === 'showUpdate' ? $abteilung->getName() : ''; ?>"></td>
        </tr>

        <tr>
            <td><input type="submit" value="senden"></td>
            <td></td>
        </tr>
    </table>
</form>
</body>
</html>