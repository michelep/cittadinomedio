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
		<h1>Congratulazioni!</h1>
		<p class="lead"><b>Hai completato la visualizzazione di tutti i consigli al momento presenti su Cittadino Medio.</b></p>
		<p class="lead">Non è finita qui, ovviamente: ogni giorno aggiungiamo nuovi consigli e, se hai suggerimenti da darci, puoi
		 scriverci una mail a <a href="mail:cittadinomedio@protonmail.com">cittadinomedio@protonmail.com</a> oppure contattarci via <a href="https://twitter.com/MedioCittadino">Twitter</a>.</p> 
		<hr>
    		<p class="lead">Se il nostro progetto ti è piaciuto, sarebbe fantastico se tu lo condividessi anche con i tuoi amici!</p>
		<div class="share text-center">
		    <ul>
			<li><a href="https://www.facebook.com/sharer.php?u=cittadinomedio.online"><i class="fa fa-facebook"></i></a></li>
		    	<li><a href="https://twitter.com/share?url=cittadinomedio.online&text=Wow! Io ho appena completato il percorso. E tu?&via=cittadinomedio"><i class="fa fa-twitter"></i></a></li>
			<li><a href="https://www.linkedin.com/shareArticle?url=cittadinomedio.online&title=Cittadino Medio"><i class="fa fa-linkedin"></i></a></li>
			<li><a href="whatsapp://send?text=cittadinomedio.online" data-action="share/whatsapp/share" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
		    </ul>
		</div>
	    </main>
<?php 
// FOOTER
getFooter();
//
?>
	</div>
    </body>
</html>
