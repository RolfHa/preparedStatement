<?php

abstract class Dbconn
{
    public static function getConn(): PDO
    {
        try {
            // hier ist der Bereich, der möglicherweise nicht funktioniert
            // möglicherweise nicht funktioniert beduetet:
            // Zugriff auf Dinge, die "außerhalb der Programmierung" liegen, z.B.
            // Datenbankzugriff, Dateizugriff, Zugriff auf fremde Rechner,
            // falsche Eingaben durch user
            return new PDO("mysql:host=" . SERVERNAME . ";dbname=" .
                DB_NAME, USERNAME, PASS);
        } catch (Exception $e){
            // in $e stehen viele eingebaute Infos zum aufgetretenen Fehler drin

            throw new Exception($e);
            // "wirft" einen Fehler und sucht nach einem try-catch, welches die
            // frisch erstellte Exception auffängt, hier der catch-Teil in der
            // index.php-Datei
        }
    }
}