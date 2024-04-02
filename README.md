# Aufgabe Bewerber WebDev

## Erstellung eines Suchfrontends

Die Anwendung umfasst:

-   ein Kommando zum Synchronisieren der gegebenen API in die Anwendung
-   die Startseite, von der aus Nutzer gesucht werden können
-   Alternativ eine Nutzersuche mit Infinite Scrolling
-   eine Detailseite der Nutzer, damit die Suchergebnisse auf eine Seite verweisen können

## Genutzte Tools

-   Die Anwendung wurde mit Laravel Sail gebaut
-   Für das Frontend wurde vue.js 3 genutzt
-   TailwindCSS wurde für das Design genutzt
-   pint, prettier, larastan und phpunit wurden als Code-Analyzer, Fixer bzw Testframework genutzt
-   Die .env ist auf sqlite konfiguriert

## Einrichten

-   eine docker-compose.yml Datei passend zur vorgegebenen Konfiguration ist beigefügt. Falls die Anwendung lokal gestartet wird, bitte noch den `APP_PORT` und die `APP_URL` anpassen
-   In der .env Datei sind 5 Variablen einzutragen, diese schicke ich per E-Mail
-   Der Rest sollte Standard Laravel Installation sein, also den `APP_KEY` und natürlich Installation von composer und npm

## Bedienen der Anwendung

### Synchronisieren per CLI

Um per CLI Nutzer von der API in die Anwendung zu Synchronisieren wurde ein Kommando `FetchUsers` erstellt.
Das Kommando kann ausgeführt werden mit `sail artisan app:fetch-users` bzw `php artisan app:fetch-users` vom lokalen Rechner.

### Aufruf der Nutzersuche

Die type-ahead Suche nach den in der Datenbank (zwischen)gespeicherten Nutzern ist über den Startpunkt der Anwendung ('/') aufrufbar.
Dabei kann nach Nutzername und Vor bzw Familienname gesucht werden.

## Geschriebene Tests

Tests wurden in kleinem Umfang für die Nutzersuche geschrieben. Das umfasst einige Standardtests wie die zurückgegebenen Statuscodes, aber auch das Verhalten der Nutzersuche. Die Tests sind hier nur Beispielhaft und sollen nicht die gesamte Anwendung durchtesten.

## Designentscheidungen

### GUI

Die GUI ist aufgrund des kleinen Anwendungsumfangs sehr simpel gehalten. Zu einer Navigationsleiste gibt es einen Content-Block. Für die Nutzersuche erscheinen die Ergebnisse nach Eingabe der Suche direkt darunter aufgelistet. Da die Vorgabe mit type-ahead hier sehr frei war, habe ich mich dagegen entschieden Pagination einzubauen. Um Performanceprobleme, sowie Probleme mit der Anzeige zu vermeiden, werden die Ergebnisse auf maximal 8 Nutzer limitiert. Die Vorschläge sind daher also eine Hilfe, Nutzer einfacher zu finden, als eine klassische Auflistung.  
Alternativ hierzu wurde die Nutzersuche als Infinite Scrolling implementiert
Die Detailseite eines Benutzers wurde hauptsächlich eingepflegt, um die Ergebnisse aus voriger Liste verlinken zu können.

### Genutzte Pakete

Um schneller zum Ziel zu kommen, wurden einige Pakete genutzt. Dies sind:

-   [lodash](https://github.com/lodash/lodash)
-   [axios](https://github.com/axios/axios)
-   [ziggy](https://github.com/tighten/ziggy)

### Software Architektur

Es gibt lediglich einen Controller für die Anwendung, den `SchulcampusUserController`.  
Die Methode `fetch` wird per AJAX angesprochen, um Nutzer zu suchen und gibt eine API Resource zurück, um die Ergebnisse simpel passend darstellen zu können.

Im Frontend habe ich versucht, die Architektur simpel zu halten. Lediglich einige Komponenten wie die Navigationsleiste wurden ausgelagert, die Suchlogik dagegen ist direkt auf den jeweiligen Seiten gehalten.

Um die Nutzer zu synchronisieren, wurde ein Service `SynchronizeUsersService` erstellt. Dies ermöglicht die Wiederverwendung zum Beispiel per Scheduler. Ebenso wurde die Logik als zu komplex für direktes Hinterlegen im Command eingestuft.  
Stattdessen wurde versucht, jeden Abschnitt der Synchronisation in eine eigene Methode zu stecken und per `fromApi` als Handler aufzurufen.

## Projektvorgehen

Zu Beginn des Projektes wurde die Anwendung in verschiedene Teile aufgeteilt:

-   Die Datenbank und Modelstruktur
-   Der Controller sowie das Frontend, um Nutzer anzeigen zu lassen
-   Ein Kommmando, das Daten aus der API importiert und in die projekteigene Datenbank schreibt
    Begonnen wurde mit dem Frontend, besonders dem vue.js Teil, da hier aufgrund fehlender Erfahrung das größte Fehlerpotential bestand.

Im zweiten Schritt wurde eine Tabelle auf der DB für die Nutzer erstellt und per Seeder mit Testdaten gefüllt. Dies ermöglichte dann die Nutzung aus dem Controller, um bei der Nutzersuche Ergebnisse an das Frontend zurückzugeben.

Erst im letzten Schritt wurde dann die Api angesprochen und Nutzer importiert. Hier waren Änderungen in der Tabellenstruktur nötig (bedingt durch die bis dahin unbekannte Struktur der Rückgabewerte der Api). Diese waren voraussehbar und als nicht zeitintensiv eingestuft.

Abschließend wurden kleinere Optimierungen vorgenommen und das Projekt ein wenig aufgeräumt.

Aufgrund des kleinen Projektsumfangs wurde auf detaillierte Planung wie ER-Diagramme verzichtet.

## Weitere Schritte

Nächste Schritte in einem echten Projekt wären Punkte wie Rate Limiting, ein Schedule für das Importieren der Nutzer, sowie sinnvolles Errorhandling beim Import der Daten.
