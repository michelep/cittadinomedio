<?php

include __DIR__."/common.inc.php";

?>
<!doctype html>
<html lang="it" class="h-100">
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
			<a class="nav-link" href="/il-progetto">Il progetto</a>
			<a class="nav-link" href="/partecipa">Partecipa</a>
		    </nav>
		</div>
	    </header>

	    <main class="px-1">
		<h1>Privacy Policy</h1>
		<p class="lead">
		    Abbiamo scelto di non includere alcun tracker all'interno del sito web cittadinomedio.it, per proteggere la tua privacy. Queste pagine sono accessibili anche via TOR, se desideri maggiore anonimato.
		</p><p class="lead">
		    Il trattamento dei dati raccolti è necessario per fornire il servizio ed è limitato esclusivamente ai dati tecnici relativi la connessione. Viene memorizzato sul browser dell'utente solo il cookie di sessione PHPSESSID, che contiene l'ID univoco della sessione generata dall'interprete PHP e necessario per memorizzare alcune variabili temporanee, valido fino alla fine della sessione di visita.
		</p><p class="lead">
		    Il server web memorizza, per 15 giorni, i seguenti dati dei visitatori: IP, timestamp, pagine web visitate e tipologia di browser. Questi dati sono poi anonimizzati, elaborati ed aggregati per computare statistiche sulle visite.
		</p><p class="lead">
		    Il Titolare del trattamento (Art.4 del regolamento UE2016/679) è Michele Pinassi. I dati sono conservati e trattati su un server virtuale ospitato dal provider <a href="https://www.hetzner.com/">Hetzner</a> entro i confini dell'Unione Europea. Per qualsiasi domanda relativa al trattamento dei dati o per esercitare i propri diritti, come previsto dalla normativa, potete scrivere a <a href="mail:cittadinomedio@protonmail.com">cittadinomedio@protonmail.com</a>.
		</p>
	    </main>
<?php 
// FOOTER
getFooter();
//
?>
	</div>
    </body>
</html>
