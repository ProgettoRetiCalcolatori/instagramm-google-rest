Progetto per l'esame di Reti di Calcolatori.

I due file presenti nel repository sono:
rest.php: Implemena il servizio Rest richiesto
client.php: Un client di prova che utilizza il servizio Rest

Una prova del client può essere fatta al seguente indirizzo: http://simonetruglia.altervista.org/progettoreti

Il servizio rest implementato nel file rest.php permette di ottenere una lista di fotografie inserite sul social network Instagram da determinati utenti che presentano il location_tag di una specifica area geografica.

L'utilizzo del servizio è molto semplice, basta infatti accedere al seguente URL:
nomedominio/rest.php?tkn=INSTAGRAM_ACCESS_TOKEN&location=LOCATION

Dove abbiamo:

INSTAGRAM_ACCESS_TOKEN: Un access token valido per un utente Istagram che ha preventivamente autorizzato l'applicazione che vuole fare uso del servizio rest.
Per dettagli fare riferimento a https://www.instagram.com/developer/authentication/
In particolare, solo un utente che possiede un valido access token potrà visualizzare le fotografie di tutti e soli che utenti che hanno preventivamente autorizzato l'applicazione client.

LOCATION: Nome proprio di una località, es: Roma.


