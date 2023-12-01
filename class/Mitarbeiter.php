<?php

class Mitarbeiter
{
    private int|null $id;
    private string|null $vorname;
    private string|null $nachname;

    /**
     * @param int|null $id
     * @param string|null $vorname
     * @param string|null $nachname
     */
    public function __construct(int $id = null, string $vorname = null, string $nachname = null)
    {
        if (isset($id)) {
            $this->id = $id;
            $this->vorname = $vorname;
            $this->nachname = $nachname;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getVorname(): string
    {
        return $this->vorname;
    }

    /**
     * @param string $vorname
     * @return void
     */
    public function setVorname(string $vorname): void
    {
        $this->vorname = $vorname;
    }

    /**
     * @return string
     */
    public function getNachname(): string
    {
        return $this->nachname;
    }

    /**
     * @param string $nachname
     * @return void
     */
    public function setNachname(string $nachname): void
    {
        $this->nachname = $nachname;
    }

    /**
     * @param string $vorname
     * @param string $nachname
     * @return Mitarbeiter
     */
    public function createObject(string $vorname, string $nachname):Mitarbeiter
    {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("INSERT INTO mitarbeiter (vorname, nachname) VALUES (:vorname, :nachname)");
        // insert one row
        $stmt->bindParam('vorname', $vorname, PDO::PARAM_STR);
        $stmt->bindParam('nachname', $nachname, PDO::PARAM_STR);
        $stmt->execute();

        return new Mitarbeiter($pdo->lastInsertId(), $vorname, $nachname);
    }

    /**
     * @return Mitarbeiter[]|false
     */
    public function getAllAsObjects(){
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("SELECT * FROM mitarbeiter");
        $stmt->execute();
        $mitarbeiters = $stmt->fetchAll(PDO::FETCH_CLASS, 'Mitarbeiter');
        return $mitarbeiters;
    }

    /**
     * @param int $id
     * @return Mitarbeiter|false
     */
    public function getObjectById(int $id):Mitarbeiter {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("SELECT * FROM mitarbeiter WHERE id=:id");
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $m = $stmt->fetchObject('Mitarbeiter');
        return $m;
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteObject(int $id):void {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("DELETE FROM mitarbeiter WHERE id=:id");
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function updateObject():void {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("UPDATE mitarbeiter SET vorname=:vorname, nachname=:nachname WHERE id=:id");
        $stmt->bindParam('id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam('vorname', $this->vorname, PDO::PARAM_STR);
        $stmt->bindParam('nachname', $this->nachname, PDO::PARAM_STR);
        $stmt->execute();
    }
}