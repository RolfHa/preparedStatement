<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<form method="post" action="index.php">
    <input type="hidden" name="action" value="checkLogin">
    <label for="name">Name: </label> <input type="text" name="name" id="name"><br>
    <label for="passwort">Passwort: </label> <input type="password" name="passwort" id="passwort"><br>
    <input type="submit">
</form>
</body>
</html>