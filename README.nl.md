# Realtime Energy

Go to the [English readme](https://github.com/stubbornbe/realtime-energy/blob/main/README.nl.md)

Webapp om energieverbruik in real time weer te geven, gebaseerd op live data uit teller met P1-port en SMA omvormer.

![mockup-small](https://github.com/user-attachments/assets/fb0771be-82e6-452d-bec4-2a595e65fb29)

## Beschrijving
De meeste mensen met een digitale meter en zonnepanelen lopen tegen het zelfde probleem aan: Hoe lees ik live nuttige info uit? Energiebedrijven voorzien je met historische data, maar altijd met een grote vertraging. Wanneer je bvb in België woont en nutsbedrijven beslissen om je extra's aan te rekenen wanneer je energieverbruik boven een bepaalde waarde gaat, ligt het voor de hand dat je on-the-fly moet weten wat je huidige afname is. En dit is exact wat deze kleine webapp voorziet.

Iedere 2 seconden wordt je reeële afname van het net berekend, gebaseerd op wat je verbruikt en wat je zonnepanelen opbrengen.
Rekening houdende met die waarde kan je beslissen of het opportuun is om nog een "grote verbruiker" te starten zoals een wasmachine of stofzuiger.
Je kan ook een alarmpijl instellen.

De verkregen data stelt je in staat om verdere interacties op te zetten met domotica en andere logging software.

Dit project omvat niet enkel de code van de webapp, maar ook alle stappen genomen om de P1 poort en SMA web API uit te lezen.

## Functies

- Weergave opbrengst zonnepanelen
- Weergave eigen verbruik
- Weergave afname/injectie naar het net
- Alarm wanneer afname boven bepaalde limiet gaat
- Weergave huidige maandpiek
- Weergave gemidded verbruik laatste 15 min

## Syteemvereisten

- Linux gebaseerd OS
- Een digitale teller met aangesloten P1 poort via com-poort of USB convertor
- Een SMA gebaseerde omvormer van zonnepanelen verbonden met je LAN netwerk
- Apache webserver
- Php
- Python
- Wat knutseltijd, want dit project heeft geen kant en klare installer

### Optioneel

- Cacti voor historische rrd logging

## Installatie en configuratie

Alle installatie en configuratiestappen kan je terugvinden in de Wiki:

- Digitale meterwaarden uitlezen naar json file
- Omvormer zonnepanelen uitlezen naar json file
- Services in Linux opzetten om het verzamelen te automatiseren en in de lucht te houden
- Verschillende debugtips
- De json files linken aan het webproject zodat je het kan gebruiken

### Optioneel

- Configureer Cacti zodat deze historische logging doet van de json files

## Dank aan
- jensdepuydt: Om mij een basis Python script te voorzien om P1 telegrams uit te lezen
