<?php

class Abteilung implements ITableBasics
{
    private int|null $id;
    private string|null $name;

    /**
     * @var Mitarbeiter[]
     */
    private array $mitarbeiterArr;

    /**
     * @param int|null $id
     * @param string|null $vorname
     * @param string|null $nachname
     */
    public function __construct(int $id = null, string $name = null, array $mitarbeiterArr = null)
    {
        if (isset($id)) {
            $this->id = $id;
            $this->name = $name;
            if (isset($mitarbeiterArr)){
                $this->mitarbeiterArr = $mitarbeiterArr;
            }
        }
    }

    /**
     * @return array|Mitarbeiter[]
     */
    public function getMitarbeiterArr(): array
    {
        return $this->mitarbeiterArr;
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
     * @param string $name
     * @return Abteilung
     * @throws Exception
     */
    public function createObject(string $name): Abteilung
    {
        try {
            $pdo = Dbconn::getConn();
            $stmt = $pdo->prepare("INSERT INTO abteilung (name) VALUES (:name)");
            // insert one row
            $stmt->bindParam('name', $name, PDO::PARAM_STR);
            $stmt->execute();

            return new Abteilung($pdo->lastInsertId(), $name);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @return Abteilung[]
     * @throws Exception
     */
    public function getAllAsObjects() : array
    {
        try {
            $pdo = Dbconn::getConn();
            $stmt = $pdo->prepare("SELECT * FROM abteilung");
            $stmt->execute();
            $abteilungen = $stmt->fetchAll(PDO::FETCH_CLASS, 'Abteilung');
            // Erweiterung: zu jeder Abteilung sollen die Mitarbeiter geladen werden
            for ($i = 0; $i <count($abteilungen) ; $i++) {
                $m = new Mitarbeiter();
                $abteilungen[$i]->mitarbeiterArr = $m->getObjectsByAbteilungId($abteilungen[$i]->id);
            }

            return $abteilungen;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param int $id
     * @return Abteilung
     * @throws Exception
     */
    public function getObjectById(int $id): Abteilung
    {
        try {
            $pdo = Dbconn::getConn();
            $stmt = $pdo->prepare("SELECT * FROM abteilung WHERE id=:id");
            $stmt->bindParam('id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $m = $stmt->fetchObject('Abteilung');
            return $m;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteObject(int $id): void
    {
        // FK Fehlermeldung erscheint, wenn es einen Mitarbeiter gibt, der im
        // Attribute abteilungId den Wert von $id hat
        // dies müssen wir abfangen mit try-catch
        try {
            $pdo = Dbconn::getConn();
            $stmt = $pdo->prepare("DELETE FROM abteilung WHERE id=:id");
            $stmt->bindParam('id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
echo $e->getMessage();
// @todo Unterscheiden, ob SQLSTATE == 42S02 (table not found)
// oder SQLSTATE == 23000 (FK constraint)
            throw new Exception('Fehler! Es gibt noch Mitarbeiter in dieser Abteilung<br>' .
                'Löschen nicht möglich');
        }
    }

    public function updateObject(): void
    {
        $pdo = Dbconn::getConn();
        $stmt = $pdo->prepare("UPDATE abteilung SET name=:name WHERE id=:id");
        $stmt->bindParam('id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam('name', $this->name, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function getSelectOptionElement(Mitarbeiter $m = null): string
    {
        if (!isset($m)) {
            // Ziel: hartcodierten Code aus db dynamisch zu erstellen
            $html = '<select name="abteilungId" id="abteilungId">';
            $abteilungen = $this->getAllAsObjects();
            foreach ($abteilungen as $a) {
                $html .= '<option value="' . $a->getId() . '">' . $a->getName() . '</option>';
            }
            $html .= '</select>';
        } else {
            $html = '<select name="abteilungId" id="abteilungId">';
            $abteilungen = $this->getAllAsObjects();
            $abtId = $m->getAbteilungId();
            foreach ($abteilungen as $a) {
                $selected = '';
                if ($abtId === $a->getId()) {
                    $selected = ' selected';
                }
                $html .= '<option value="' . $a->getId() . '"' . $selected . '>'
                    . $a->getName() . '</option>';
            }
            $html .= '</select>';
        }
        return $html;
    }
}