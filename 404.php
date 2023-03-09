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
			<a class="nav-link" href="/partecipa">Partecipa</a>
		    </nav>
		</div>
	    </header>

	    <main class="px-3">
		<h1>404</h1>
		<p class="lead">La pagina che stai cercando di visitare non esiste. Ci dispiace per l'inconveniente e, se vuoi segnalarcelo via mail a <a href="cittadinomedio@protonmail.com">cittadinomedio@protonmail.com</a>, te ne saremo davvero grati.</p>
	    </main>
<?php 
// FOOTER
getFooter(); 
//
?>
	</div>
    </body>
</html>
