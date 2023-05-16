drop database if exists serie_a;
create database serie_a;
use serie_a;

create table squadra(
id int primary key,
nome varchar (255) not null
);

create table partita(
id int primary key,
giornata int,
squadra_casa int,
squadra_ospite int,
reti_casa int,
reti_ospiti int,
foreign key (squadra_casa) references squadra(id),
foreign key (squadra_ospite) references squadra(id)
);

create table classifica(
id int primary key,
squadra int,
punti int,
GF int,
GS int,
vinte int,
pareggi int,
sconfitte int,
foreign key (squadra) references squadra(id)
);

