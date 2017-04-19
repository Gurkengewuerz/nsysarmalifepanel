<?php

define("mysql_host", "localhost"); // Datenbank Adresse
define("mysql_user", ""); // Datenbank Benutzer
define("mysql_pw", ""); // Datenbank Passwort
define("mysql_db", "altislife"); // Datenbank Name

define("site_name", "Nsys Arma Life Panel"); // Seitentitel
define("site_shortname", "NALP"); // Seiten Kürzel
define("site_url", "http://example.com/"); // http://example.com/
define("site_version", "v1.0");

define("cop_ranks", "7"); // Maximale Polizei Ränge
define("medic_ranks", "7"); // Maximale Medic bzw. EMS Ränge

$pdo = new PDO('mysql:host='.mysql_host.';dbname='.mysql_db, mysql_user, mysql_pw);
