DROP DATABASE IF EXISTS serie_a;
CREATE DATABASE serie_a;
USE serie_a;

-- Creazione della tabella "squadra"
CREATE TABLE squadra (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50)
) AUTO_INCREMENT=1;

-- Creazione della tabella "partita"
CREATE TABLE partita (
  id INT AUTO_INCREMENT PRIMARY KEY,
  giornata INT,
  squadra_casa INT,
  squadra_ospite INT,
  reti_casa INT,
  reti_ospite INT,
  FOREIGN KEY (squadra_casa) REFERENCES squadra(id),
  FOREIGN KEY (squadra_ospite) REFERENCES squadra(id)
) AUTO_INCREMENT=1;

-- Creazione della tabella "classifica"
CREATE TABLE classifica (
  id INT AUTO_INCREMENT PRIMARY KEY,
  squadra INT,
  punti INT,
  GF INT,
  GS INT,
  vinte INT,
  pareggi INT,
  sconfitte INT,
  FOREIGN KEY (squadra) REFERENCES squadra(id)
) AUTO_INCREMENT=1;


INSERT INTO `squadra` (`id`, `nome`) VALUES
(1, 'atalanta'),
(2, 'bologna'),
(3, 'cremonese'),
(4, 'Empoli'),
(5, 'fiorentina'),
(6, 'hellas Verona'),
(7, 'inter'),
(8, 'Juventus'),
(9, 'Lazio'),
(10, 'lecce'),
(11, 'milan'),
(12, 'Monza'),
(13, 'napoli'),
(14, 'roma'),
(15, 'salernitana'),
(16, 'Sampdoria'),
(17, 'Sassuolo'),
(18, 'spezia'),
(19, 'torino'),
(20, 'udinese');

