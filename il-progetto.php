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
	    <header class="mb-auto">
		<div>
		    <h3 class="float-md-start mb-0 logo"><a href="/">Cittadino Medio</a></h3>
		    <nav class="nav nav-masthead justify-content-center float-md-end">
			<a class="nav-link" href="/">Home</a>
			<a class="nav-link active"  aria-current="page" href="/il-progetto">Il progetto</a>
			<a class="nav-link" href="/partecipa">Partecipa</a>
		    </nav>
		</div>
	    </header>

	    <main class="px-3">
		<h1>Il progetto</h1>
		<p class="lead">Cittadino Medio vuole essere un progetto libero per sensibilizzare la cittadinanza a temi come privacy, cybersecurity e anonimato in Rete utilizzando messaggi semplici, efficaci e offrendo soluzioni pratiche.</p>
		<p class="lead">Il nostro (ambizioso) obiettivo &egrave; stimolare il dibattito e sensibilizzare a tematiche che crediamo essere fondamentali per la tutela delle nostre libert&agrave; civili, politiche e democratiche.</p>
<?php
$result = doQuery("SELECT ID FROM Quotes");
echo "<hr><h4>Attualmente abbiamo ".$result->rowCount()." \"pillole\" nel nostro archivio</h4>
<a href=\"/t/dailytop\">Quale &egrave; la pillola pi&ugrave; cliccata oggi?</a><hr>";
?>
		<p class="lead">Siamo consapevoli che talvolta è impossibile affrontare argomenti complessi in poche righe: cerchiamo di fare del nostro meglio per sintetizzare le informazioni, sacrificandone purtroppo la completezza, nell'ottica di 
		offrire soprattutto spunti di riflessione.</p>
		<p class="lead">Tutti i contenuti sono sotto <a href="https://creativecommons.org/licenses/by-sa/4.0/deed.it">licenza CC BY-SA</a></p>
		<p class="lead">Il progetto è stato ideato e mantenuto da <a href="http://www.zerozone.it" target=_new>Michele <i>"O-Zone"</i> Pinassi</a>. &Egrave; aperto a chiunque desideri <a href="/partecipa">partecipare</a>, suggerendo nuovi consigli e migliorie.</p>
		<p class="lead">Potete rimanere aggiornati sul progetto anche via Twitter <a href="https://twitter.com/MedioCittadino" target="_new">@MedioCittadino</a> e, se volete supportarlo, potete <i>regalarvi una bella t-shirt</i> su <a href="https://shop.spreadshirt.it/cittadinomedio/" target="_new">spreadshirt.it</a></p>
	    </main>
<?php 
// FOOTER
getFooter(); 
//
?>
	</div>
    </body>
</html>
