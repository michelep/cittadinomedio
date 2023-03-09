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
			<a class="nav-link" aria-current="page"  href="/partecipa">Partecipa</a>
		    </nav>
		</div>
	    </header>

	    <main class="px-3">
<?php
if((isset($_GET["s"])&&(strlen($_GET["s"]) > 0))) {
    $searchTerm = preg_replace("/[^a-zA-Z0-9_]+/", "", $_GET["s"]);

    if(strncmp($searchTerm,'_all',15)==0) {
	$result = doQuery("SELECT ID FROM Quotes ORDER BY addDate DESC");
	if($result->rowCount() > 0) {
	    echo "<div class=\"search-list-box\"><ul class=\"list-group list-group-flush\">";
	    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$quoteId = $row["ID"];
		$myQuote = new Quote($quoteId);
		echo "<li class=\"list-group-item bg-dark text-white search-list\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>&nbsp;<a href=\"".$myQuote->getURL()."\">$myQuote->Title</a></li>";
	    }
	    echo "</ul></div>";
	}
    } else { 
	$result = doQuery("SELECT ID, MATCH(Title, Description) AGAINST(:searchterm IN BOOLEAN MODE) AS Score FROM Quotes WHERE MATCH(Title, Description) AGAINST (:searchterm IN BOOLEAN MODE) ORDER BY Score",array(":searchterm" => $searchTerm));
	if($result->rowCount() > 0) {
	    echo "<div class=\"search-list-box\"><h4>Abbiamo ".$result->rowCount()." risultati per te:</h4><ul class=\"list-group list-group-flush\">";
	    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$quoteId = $row["ID"];
		$matchScore = $row["Score"];
		$myQuote = new Quote($quoteId);
		echo "<li class=\"list-group-item bg-dark text-white search-list\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>&nbsp;<a href=\"".$myQuote->getURL()."\">$myQuote->Title</a></li>";
	    }
	    echo "</ul></div>";
	} else {
	    echo "<h4><i class=\"fa fa-hand-spock-o\" aria-hidden=\"true\"></i> Nessun risultato!</h4>";
	}
    }
} else {
?>
		<h1>Stai cercando qualcosa di preciso?</h1>
		<p class="lead">Il nostro portale è progettato per dispensare consigli secondo un ordine casuale. Ma se vuoi cercare un argomento, puoi farlo da qui.</p>
<?php
}
?>
		<hr>
		<form method="GET">
		    <div class="input-group">
			<input class="form-control" list="tagsList" id="tagsListForm" name="s" placeholder="Cosa vuoi cercare?">
			<datalist id="tagsList">
<?php
    $result = doQuery("SELECT Tag FROM Tags;");
    if($result) {
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	    $tag_value = $row["Tag"];
	    echo "<option value=\"$tag_value\">";
	}
    }
?>
			</datalist>
			<input type="submit" class="btn btn-primary" value="Cerca">
		    </div>
		</form>
		<p class="lead">oppure puoi visualizzare la <a href="/search?s=_all">lista completa dei consigli</a>.</p>
	    </main>
<?php 
// FOOTER
getFooter();
//
?>
	</div>
    </body>
</html>
