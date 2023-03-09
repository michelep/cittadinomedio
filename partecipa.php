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
			<a class="nav-link" href="/il-progetto">Il progetto</a>
			<a class="nav-link active" aria-current="page"  href="/partecipa">Partecipa</a>
		    </nav>
		</div>
	    </header>

	    <main class="px-3">
		<h1>Partecipa al progetto!</h1>
		<p class="lead">Vuoi suggerire un comportamento sbagliato da aggiungere? Vuoi segnalare una risposta non corretta o suggerirne un miglioramento? Vuoi contribuire allo sviluppo della piattaforma?</p>
		<p class="lead">Unisciti al gruppo Telegram <a href="https://t.me/cittadinomedio">t.me/cittadinomedio</a>, per entrare in contatto con la community, oppure scrivi una mail a <a href="mail:cittadinomedio@protonmail.com">cittadinomedio@protonmail.com</a>. 
		Puoi contribuire al codice direttamente via PR da Github sul repo <a href="https://github.com/michelep/cittadinomedio">github.com/michelep/cittadinomedio</a>.</p>
	    </main>
<?php 
// FOOTER
getFooter(); 
//
?>
	</div>
    </body>
</html>
