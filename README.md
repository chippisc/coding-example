# Aufgabe Bewerber WebDev

## Erstellung eines Suchfrontends

Die Anwendung umfasst:

-   ein Kommando zum Synchronisieren der gegebenen API in die Anwendung
-   die Startseite, von der aus Nutzer gesucht werden können
-   eine Detailseite der Nutzer, damit die Suchergebnisse auf eine Seite verweisen können

## Genutzte Tools

-   Die Anwendung wurde mit Laravel Sail gebaut
-   Für das Frontend wurde in sehr kleinem Umfang vue.js 3 genutzt
-   TailwindCSS wurde für das Design genutzt
-   pint, prettier, larastan und phpunit wurden als Code-Analyzer, Fixer bzw Testframework genutzt
-   Die .env ist auf sqlite konfiguriert

## Einrichten

-   eine docker-compose.yml Datei passend zur vorgegebenen Konfiguration ist beigefügt. Falls die Anwendung lokal gestartet wird, bitte noch den `APP_PORT` und die `APP_URL` anpassen
-   In der .env Datei sind 5 Variablen einzutragen, diese schicke ich per E-Mail
-   Der Rest sollte Standard Laravel sein, also den `APP_KEY` und natürlich Installation von composer und npm

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

Die GUI ist aufgrund des kleinen Anwendungsumfangs sehr simpel gehalten. Das Suchfeld steht zentral, die Ergebnisse erscheinen nach Eingabe der Suche darunter aufgelistet. Da die Vorgabe mit type-ahead hier sehr frei war, habe ich mich dagegen entschieden Pagination einzubauen. Um Performanceprobleme zu vermeiden, werden die Ergebnisse auf maximal 20 Nutzer limitiert. Die Vorschläge sind daher also eine Hilfe, Nutzer einfacher zu finden, als eine klassische Auflistung.  
Die Detailseite eines Benutzers wurde hauptsächlich eingepflegt, um die Ergebnisse aus voriger Liste verlinken zu können.

### Genutzte Pakete

Um schneller zum Ziel zu kommen, wurden einige Pakete genutzt. Dies sind:

-   [lodash](https://github.com/lodash/lodash)
-   [axios](https://github.com/axios/axios)
-   [ziggy](https://github.com/tighten/ziggy) (Aufgrund meiner fehlenden Erfahrung mit vue.js habe ich versucht, das Routing simpel zu halten. Dieses Paket bietet eine Möglichkeit, von vue.js auf die normalen benannten Routen in Laravel zuzugreifen)

### Software Architektur

Es gibt lediglich einen Controller für die Anwendung, den `SchulcampusUserController`. Die beiden Methoden `index` und `show` halten sich dabei an den von Laravel vorgeschlagenen CRUD Standard.  
Die Methode `fetch` wird per AJAX angesprochen, um Nutzer zu suchen und gibt eine API Resource zurück, um die Ergebnisse simpel passend darstellen zu können.

Im Frontend habe ich versucht, die Architektur sehr simpel zu halten. Es gibt lediglich einen vue.js Komponenten für die Nutzersuche. Auslagern z.B. des Suchfeldes habe ich aufgrund der Anwendungsgröße als nicht zwingend notwendig befunden. Um den AJAX CAll zu starten, habe ich einen Watcher genutzt, da diese flexibler als Computed Properties scheinen.

Um die Nutzer zu synchronisieren, wurde ein Service `SynchronizeUsersService` erstellt. Dies ermöglicht die Wiederverwendung zum Beispiel per Scheduler. Ebenso wurde die Logik als zu komplex für direktes Hinterlegen im Command eingestuft.  
Stattdessen wurde versucht, jeden Abschnitt der Synchronisation in eine eigene Methode zu stecken und per `fromApi` als Handler aufzurufen.
