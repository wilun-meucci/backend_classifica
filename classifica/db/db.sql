drop database if exists serie_a;
create database serie_a;
use serie_a;

create table classifica(
pos int primary key not null auto_increment,
squadra varchar(64) not null,
V int,
P int,
S int,
GR int,
GS int,
DR int,
punti int
);

insert into classifica(squadra) values
("Juventus"),
("Fiorentina"),
("Roma CF"),
("Atalanta"),
("Inter FC"),
("AC Milan"),
("Napoli"),
("Lazio"),
("Lecce"),
("Sampdoria"),
("Udinese"),
("Bologna FC"),
("Torino"),
("Sassuolo Calcio"),
("AC Monza"),
("Empoli FC"),
("US Salernitana"),
("Spezia Calcio"),
("Hellas Verona"),
("Cremonese");