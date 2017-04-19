# Über
Das Nsys Arma Life Control Panel dient zur Datenbank verwaltung eines [Arma Life](https://github.com/AsYetUntitled/Framework) Servers der Version 5.0.x

# Features
+ Spieler Panel(Übersicht der eigenen Daten)
+ Support Panel
+ + Whitelistung (Cop / Medic)
+ + Daten Bearbeiten (Bargeld/Bank/AdminLevel)
+ + Fahrzeuge Reparieren / Zerstören
+ + Anzeige von Gangs
+ + Anzeige von Häusern
+ + Spielern Notizen zuweisen(z.B. Support Fälle)
+ + Lizenzen von Spielern Editieren
+ Rechte Verwaltung für diverse Aktionen
+ Log's der Support aktionen
+ Medic Panel
+ + Whitelistung von Mitgliedern
+ + Mitglieder Übersicht
+ Cop Panel
+ + Whitelistung von Mitgliedern
+ + Mitglieder Übersicht

# Installation
### Vorraussetzungen
+ Einen Webspace mit der PHP Version 5.6
+ Eine MySQL Datenbank die bereits die Tabellen von [Arma Life](https://github.com/AsYetUntitled/Framework) 5.0.x beinhaletet.
### Installation
1. Die install.sql aus dem Hauptverzeichnis muss in die Life Datenbank eingespielt werden damit die Benötigten Tabellen erstellt werden.
2. Als nächstes muss man einen Steam WebAPI-Key beantreagen, diesen findet man hier http://steamcommunity.com/dev/apikey
2.1 Den Key muss man nun in **steamauth/SteamConfig.php** in der Zeile 3 eintragen.
2.2 In Zeile 4 muss dann noch eure Domain eingetragen werden.
3. Nun geht man in den Ordner **core/** und öffnet die **config.php**.
3.1 Dort tragt ihr nun eure MySQL daten ein und passt die Restlichen Sachen nach euren wünschen an.
4. Habt ihr alles richtig eingetragen, sollte die Seite nun funktionstüchtig sein.

# Hilfe / Support
Hilfe bzw. Support bezüglich des Panels bekommt ihr [hier](https://nsys.pw/forum/board/6-nsys-arma-life-panel/).

# Andere Links
+ [AdminLTE](https://almsaeedstudio.com/)
+ [Datatables](https://datatables.net/)

# Lizenz
The nsysarmalifepanel is licensed under the GNU General Public License version 3