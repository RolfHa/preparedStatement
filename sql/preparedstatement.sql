DROP DATABASE IF EXISTS preparedstatement;
CREATE DATABASE preparedstatement;
USE preparedstatement;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `abteilung` (
                             `id` int(11) NOT NULL,
                             `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `abteilung`
--

INSERT INTO `abteilung` (`id`, `name`) VALUES
                                           (1, 'Verkauf'),
                                           (2, 'Einkauf');

CREATE TABLE user (id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(45), passwort VARCHAR(256), rolle VARCHAR(15));
INSERT INTO user(id, name, passwort, rolle)
VALUES(NULL, 'admin', '$2y$10$8LpI68r3bGXxp/T5HxKiuesmVGwQ02QXXOvnbpwcGRfq6PBCxGzRW', 'admin');
INSERT INTO user(id, name, passwort, rolle)
VALUES(NULL, 'user','$2y$10$gzuxDtagOCOFVktymDFcdecRFFblKkpZcp6loZ0zDEJHYXLMh.Z9m','user');

-- username passwort
-- admin    pan
-- user     tom
--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `abteilung`
--
ALTER TABLE `abteilung`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `abteilung`
--
ALTER TABLE `abteilung`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;



CREATE TABLE `mitarbeiter` (
                               `id` int(11) NOT NULL,
                               `vorname` varchar(45) NOT NULL,
                               `nachname` varchar(45) NOT NULL,
                               `abteilungId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `mitarbeiter`
--

INSERT INTO `mitarbeiter` (`id`, `vorname`, `nachname`, `abteilungId`) VALUES
                                                                           (1, 'Peter', 'Pan', 1),
                                                                           (3, 'Franka', 'Potente', 2);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
    ADD PRIMARY KEY (`id`),
    ADD KEY `abteilungId` (`abteilungId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
    ADD CONSTRAINT `mitarbeiter_ibfk_1` FOREIGN KEY (`abteilungId`) REFERENCES `abteilung` (`id`);
COMMIT;


