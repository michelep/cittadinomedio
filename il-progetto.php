<?php

include __DIR__."/common.inc.php";

?>
<!doctype html>
<html lang="en" class="h-100">
<?php 
// HEADER
getHeader(); 
//
?>
    <body class="d-flex h-100 text-center text-white bg-dark">
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
<?php
// NAVBAR
getNavbar();
?>
	    <main class="px-3 mt-4">
		<p class="lead mx-auto"><img class="img-fluid" src="/img/big-brother.png"></p>
		<p class="lead"><b>Cittadino Medio</b> vuole essere un progetto libero per sensibilizzare la cittadinanza a temi come privacy, cybersecurity e anonimato in Rete utilizzando messaggi semplici, efficaci e offrendo soluzioni pratiche.</p>
		<p class="lead">Il nostro (ambizioso) obiettivo &egrave; stimolare il dibattito e sensibilizzare a tematiche che crediamo essere fondamentali per la tutela delle nostre libert&agrave; civili, politiche e democratiche.</p>
<?php
$result = doQuery("SELECT ID FROM Quotes");
echo "<hr><h4>Attualmente abbiamo ".$result->rowCount()." \"pillole\" nel nostro archivio</h4>
<a href=\"/t/dailytop\">Quale &egrave; la pillola pi&ugrave; cliccata oggi?</a><hr>";
?>
		<p class="lead">Siamo consapevoli che talvolta è impossibile affrontare argomenti complessi in poche righe: cerchiamo di fare del nostro meglio per sintetizzare le informazioni, sacrificandone purtroppo la completezza, nell'ottica di 
		offrire soprattutto spunti di riflessione.</p>
		<p class="lead">Vuoi suggerire un comportamento sbagliato da aggiungere? Vuoi segnalare una risposta non corretta o suggerirne un miglioramento? Vuoi contribuire allo sviluppo della piattaforma?</p>
		<p class="lead">Unisciti al gruppo Telegram <a href="https://t.me/cittadinomedio">t.me/cittadinomedio</a>, per entrare in contatto con la community, oppure scrivi una mail a <a href="mail:cittadinomedio@protonmail.com">cittadinomedio@protonmail.com</a>. 
		Puoi contribuire al codice direttamente via PR da Github sul repo <a href="https://github.com/michelep/cittadinomedio">github.com/michelep/cittadinomedio</a>.</p>
		<p class="lead">Il progetto è stato ideato e mantenuto da <a href="http://www.zerozone.it" target=_new>Michele <i>"O-Zone"</i> Pinassi</a>. &Egrave; aperto a chiunque desideri <a href="/partecipa">partecipare</a>, suggerendo nuovi consigli e migliorie. Anche via Twitter <a href="https://twitter.com/MedioCittadino" target="_new">@MedioCittadino</a>.</p>
	    </main>
<?php 
// FOOTER
getFooter(); 
//
?>
	</div>
    </body>
</html>
