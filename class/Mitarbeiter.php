<?php

class Mitarbeiter
{
    private int|null $id;
    private string|null $vorname;
    private string|null $nachname;
    private int|null $abteilungId;

    /**
     * @param int|null $id
     * @param string|null $vorname
     * @param string|null $nachname
     */
    public function __construct(int $id = null, string $vorname = null, string $nachname = null, int $abteilungId = null)
    {
        if (isset($id)) {
            $this->id = $id;
            $this->vorname = $vorname;
            $this->nachname = $nachname;
            $this->abteilungId = $abteilungId;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getAbteilungId(): ?int
    {
        return $this->abteilungId;
    }

    public function getVorname(): ?string
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

    public function getAbteilungName():string{
        $a = new Abteilung();
        $abt = $a->getObjectById($this->abteilungId);
        return $abt->getName();
    }

    /**
     * @param string $vorname
     * @param string $nachname
     * @param int $abteilungId
     * @return Mitarbeiter
     */
    public function createObject(string $vorname, string $nachname, int $abteilungId):Mitarbeiter
    {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("INSERT INTO mitarbeiter (vorname, nachname, abteilungId) VALUES (:vorname, :nachname, :abteilungId)");
        // insert one row
        $stmt->bindParam('vorname', $vorname, PDO::PARAM_STR);
        $stmt->bindParam('nachname', $nachname, PDO::PARAM_STR);
        $stmt->bindParam('abteilungId', $abteilungId, PDO::PARAM_INT);
        $stmt->execute();

        return new Mitarbeiter($pdo->lastInsertId(), $vorname, $nachname, $abteilungId);
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
        $stmt = $pdo->prepare("UPDATE mitarbeiter SET vorname=:vorname, nachname=:nachname, abteilungId=:abteilungId WHERE id=:id");
        $stmt->bindParam('id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam('vorname', $this->vorname, PDO::PARAM_STR);
        $stmt->bindParam('nachname', $this->nachname, PDO::PARAM_STR);
        $stmt->bindParam('abteilungId', $this->abteilungId, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @param int $abteilungId
     * @return bool
     */
    public function existsMitarbeiterMitAbteilungsId(int $abteilungId):bool{
        $mitarbeiters = $this->getAllAsObjects();
        $existsAbteilungId = false;
        foreach ($mitarbeiters as $mitarbeiter){
            if ($mitarbeiter->getAbteilungId() === $abteilungId){
                $existsAbteilungId = true;
                // falls ein Mitarbeiter die abteilungsId hat
                // Abbruch, es reicht ja ein Mitarbeiter
                break;
            }
        }
        return $existsAbteilungId;
    }
}

