<?php

class Abteilung
{
    private int|null $id;
    private string|null $name;


    /**
     * @param int|null $id
     * @param string|null $vorname
     * @param string|null $nachname
     */
    public function __construct(int $id = null, string $name = null)
    {
        if (isset($id)) {
            $this->id = $id;
            $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $vorname
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * @param string $vorname
     * @param string $nachname
     * @return Mitarbeiter
     */
    public function createObject(string $name):Abteilung
    {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("INSERT INTO abteilung (name) VALUES (:name)");
        // insert one row
        $stmt->bindParam('name', $name, PDO::PARAM_STR);
        $stmt->execute();

        return new Abteilung($pdo->lastInsertId(), $name);
    }

    /**
     * @return Abteilung[]|false
     */
    public function getAllAsObjects(){
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("SELECT * FROM abteilung");
        $stmt->execute();
        $abteilungen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Abteilung');
        return $abteilungen;
    }

    /**
     * @param int $id
     * @return Abteilung|false
     */
    public function getObjectById(int $id):Abteilung {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("SELECT * FROM abteilung WHERE id=:id");
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $m = $stmt->fetchObject('Abteilung');
        return $m;
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteObject(int $id):void {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("DELETE FROM abteilung WHERE id=:id");
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function updateObject():void {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("UPDATE abteilung SET name=:name WHERE id=:id");
        $stmt->bindParam('id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam('name', $this->name, PDO::PARAM_STR);

        $stmt->execute();
    }
}