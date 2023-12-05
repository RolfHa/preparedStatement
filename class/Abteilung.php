<?php

class Abteilung implements ITableBasics
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
    public function createObject(string $name): Abteilung
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
    public function getAllAsObjects()
    {
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
    public function getObjectById(int $id): Abteilung
    {
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
    public function deleteObject(int $id): bool|string
    {
        // FK Fehlermeldung erscheint, wenn es einen Mitarbeiter gibt, der im
        // Attribute abteilungId den Wert von $id hat
        // dies müssen wir abfangen:
        // Gibt es einen Mitarbeiter mit dieser abteilungsId
        $m = new Mitarbeiter();
        $existsMitarbeiter = $m->existsMitarbeiterMitAbteilungsId($id);
        if ($existsMitarbeiter) {
            // ich kann Abteilung nicht löschen
            return 'Ich kann Abteilung nicht löschen';
        } else {
            $pdo = Dbconn::getConn();
            $stmt = $pdo->prepare("DELETE FROM abteilung WHERE id=:id");
            $stmt->bindParam('id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return false;
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