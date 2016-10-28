# 2. kodutoo (IV rühm)

## Kirjeldus

Done. 1. Võimalda oma lehel kasutajat luua ja sisselogida.
Done. 1. Kontrolli kõik kasutaja loomise ja sisselogimise vormi väljad, kui on tühjad, siis anna veateade!
Done. 1. Veendu, et mingit jama ei saaks andmebaasi salvestada (nt JavaScript). 
Done. 1. Veendu, et väljad jääksid täidetud, kui saadetakse vorm osaliselt.
1. Võimalda salvestada andmebaasi kirjeid oma ideele vastavalt (ainult sisselogitud kasutaja peaks saama salvestada).
1. Näita salvestatud kirjeid (nt tabeli kujul)

**OLULINE! ÄRA POSTITA GITHUBI GREENY MYSQL PAROOLE.** Selleks toimi järgmiselt:
  * loo eraldi fail `config.php`. Lisa sinna kasutaja ja parool ning tõsta see enda koduse töö kaustast ühe taseme võrra väljapoole
```PHP
  $serverHost = "localhost";
  $serverUsername = "username";
  $serverPassword = "password";
```
  * Andmebaasi nimi lisa aga kindlasti enda faili ja `require_once` käsuga küsi parool ja kasutajanimi `config.php` failist, siis saan kodust tööd lihtsamini kontrollida
```PHP
  // ühenduse loomiseks kasuta
  require_once("../config.php");
  $database = "database";
  $mysqli = new mysqli($servername, $username, $password, $database);
```
