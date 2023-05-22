import random

def genera_combinazioni(squadre):
    combinazioni = []
    for i in range(len(squadre)):
        for j in range(i+1, len(squadre)):
            combinazioni.append((squadre[i], squadre[j]))
            combinazioni.append((squadre[j], squadre[i]))
    return combinazioni

def randomizza_partite(combinazioni):
    partite_randomizzate = []
    squadre_giocate = set()
    while combinazioni:
        partite_giornata = []
        for _ in range(20):
            partita = random.choice(combinazioni)
            squadra_casa, squadra_ospite = partita

            if squadra_casa in squadre_giocate or squadra_ospite in squadre_giocate:
                continue
            
            partite_giornata.append(partita)
            squadre_giocate.add(squadra_casa)
            squadre_giocate.add(squadra_ospite)
            
            combinazioni.remove(partita)
            
        partite_randomizzate.append(partite_giornata)
        
    return partite_randomizzate

squadre = [
    "Atalanta",
    "Bologna",
    "Cagliari",
    "Empoli",
    "Fiorentina",
    "Genoa",
    "Hellas Verona",
    "Inter",
    "Juventus",
    "Lazio",
    "Milan",
    "Napoli",
    "Roma",
    "Salernitana",
    "Sampdoria",
    "Sassuolo",
    "Spezia",
    "Torino",
    "Udinese",
    "Venezia"
]

combinazioni = genera_combinazioni(squadre)
print("ciao")
partite_randomizzate = randomizza_partite(combinazioni)

for giornata, partite in enumerate(partite_randomizzate, start=1):
    print(f"Giornata {giornata}:")
    for partita in partite:
        squadra_casa, squadra_ospite = partita
        print(f"{squadra_casa} vs {squadra_ospite}")
    print()
