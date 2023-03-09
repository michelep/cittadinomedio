<?php

include __DIR__."/common.inc.php";

if(isset($_GET["q"])) {
    /* Get permaurl quote */
    $q = preg_replace("/[^a-z0-9\-]/", "", $_GET["q"]);

    $result = doQuery("SELECT ID FROM Quotes WHERE PermaURL=:permaurl",array(":permaurl" => $q));
    if($result->rowCount() > 0) {
	$row = $result->fetch(PDO::FETCH_ASSOC);

	$id = $row["ID"];

	$myQuote = new Quote($id);
    } else {
	header("location: /");
    }
} else if(isset($_GET["t"])) {
    /* Get a quote with specified TAG */
    $t = preg_replace("/[^a-z0-9 \-]/", "", urldecode($_GET["t"]));

    $result = doQuery("SELECT quoteId FROM QuoteTags AS t1 INNER JOIN Tags AS t2 ON t1.tagId=t2.ID WHERE t2.Tag LIKE :tag ORDER BY RAND() LIMIT 1",array(":tag" => $t));
    if($result->rowCount() > 0) {
	$row = $result->fetch(PDO::FETCH_ASSOC);

	$id = $row["quoteId"];

	$myQuote = new Quote($id);
    } else {
	header("location: /");
    }
} else {
    if($mySession->getAVP("quote-list")) {
	$quotesArray = unserialize($mySession->getAVP("quote-list"));
    } else {
	$quotesArray=array();
	/* Fetch all quotes and keep only not-yet viewed */
	$result = doQuery("SELECT ID FROM Quotes;");
	if($result->rowCount() > 0) {
	    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$id = $row["ID"];
		$quotesArray[] = $id;
	    }
	}
    }
    /* Get one random quote not yet viewed */
    if(count($quotesArray) > 0) {
	/* Pick one random quote */
	$id = array_rand($quotesArray);
	$myQuote = new Quote($id);
	unset($quotesArray[$id]);
	$mySession->setAVP("quote-list",serialize($quotesArray));
    } else {
	// No more quotes to show :-(
	header("location: /the-end");
    }
}

$mySession->setAVP("quote-id",$myQuote->ID);

// Update views counter
if(!$mySession->getAVP("quote-".$myQuote->ID)) {
    $mySession->setAVP("quote-".$myQuote->ID,true);
    doQuery("UPDATE Quotes SET Views=Views+1,dailyViews=dailyViews+1 WHERE ID=:id",array(":id" => $myQuote->ID));
}

?>
<!doctype html>
<html lang="en" class="h-100">
<?php 
// HEADER
getHeader($myQuote);
//
?>
    <body class="d-flex h-100 text-center text-white bg-dark">
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
	    <header class="mb-auto">
		<div>
		    <h3 class="float-md-start mb-0 logo"><a href="/">Cittadino Medio</a></h3>
		    <nav class="nav nav-masthead justify-content-center float-md-end">
			<a class="nav-link active" aria-current="page" href="/">Home</a>
			<a class="nav-link" href="/il-progetto">Il progetto</a>
			<a class="nav-link" href="/partecipa">Partecipa</a>
		    </nav>
		</div>
	    </header>

	    <main class="px-3">
		<div class="text-end" id="tags"><?php
		foreach($myQuote->Tags as $tag_id => $tag_value) {
		    echo "<span class=\"badge bg-dark\"><a href=\"/t/".urlencode($tag_value)."\"><i class=\"fa fa-tag\"></i> $tag_value</a></span>";
		}
?>
		</div>
		<hr>
		<h1><?php echo $myQuote->Title; ?></h1>
		<hr>
<?php
if($myQuote->Type == 2) {
/* Quiz ! */
    $ydata = yaml_parse($myQuote->Description, 0);
    
    echo "
    <div class=\"row text-start\" >
	<form class=\"needs-validation\" novalidate method=\"POST\">
	<input type=\"hidden\" name=\"quiz_id\" value=\"".md5(APG(10))."\">
	<div class=\"invalid-feedback\">Hey! Ricordati di selezionare una risposta...</div>";

    $risposta_id=0;

    foreach($ydata as $risposta) {
//	print_r($risposta);
	$risposta_id += 1;

	switch($risposta["tipo"]) {
	    case "radio":
?>
<div class="form-check">
  <input class="form-check-input" type="radio" name="risposta" id="risposta-<?php echo $risposta_id; ?>" required>
  <label class="form-check-label" for="risposta-<?php echo $risposta_id; ?>">
    <?php echo $risposta["testo"]; ?>
  </label>
</div>
<?php
		break;
	    default:
		break;
	}
    }
    echo "	<br><input type=\"submit\" class=\"btn btn-info\" value=\"Rispondi\">
	</form>
    </div>";
} else {
/* Comportamento sbagliato o migliorabile */
?>
		<p class="lead">
		    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBox" aria-expanded="false" aria-controls="collapseBox">
			<i class="fa fa-magic faa-shake animated faa-fast"></i>&nbsp;&nbsp;<b><?php $myQuote->echoType(); ?></b>
		    </button>
		</p>
		<div class="collapse" id="collapseBox">
		    <p class="lead quote-container"><?php echo nl2br($myQuote->Description); ?></p>
		    <div class="btn-group btn-group-sm" role="group">
                	<button class="btn btn-success" type="button" id="rate_like">
			    <i class="vote fa fa-thumbs-up"></i>
			    <span class="badge badge-light" id="rate_like_count"><?php echo $myQuote->Like; ?></span>
			</button>
                        <button class="btn btn-danger" type="button" id="rate_dislike">
			    <i class="vote fa fa-thumbs-down"></i>
			    <span class="badge badge-light" id="rate_dislike_count"><?php echo $myQuote->Dislike; ?></span>
			</button>
                    </div>
		    <hr>
		    <div class="share text-center">
			<ul>
			    <li><a href="https://www.facebook.com/sharer.php?u=<?php echo $myQuote->getURL(); ?>"><i class="fa fa-facebook"></i></a></li>
		    	    <li><a href="https://twitter.com/share?url=<?php echo $myQuote->getURL(); ?>&text=<?php echo prepareForTwitter($myQuote->Title); ?>&via=cittadinomedio"><i class="fa fa-twitter"></i></a></li>
			    <li><a href="https://www.linkedin.com/shareArticle?url=<?php echo $myQuote->getURL(); ?>&title=<?php echo $myQuote->Title; ?>"><i class="fa fa-linkedin"></i></a></li>
			    <li><a href="whatsapp://send?text=<?php echo $myQuote->getURL(); ?>" data-action="share/whatsapp/share" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
			    <li><a href="<?php echo $myQuote->getURL(); ?>"><i class="fa fa-link"></i></a></li>
			</ul>
		    </div>
		    <hr>
		</div>
<?php
}
?>
	    </main>
	    
	    <div class="clearfix">
		<a class="btn btn-primary btn-xs" href="/" role="button">Scopri un altro comportamento migliorabile</a><br/>
		<i>oppure prova a <a href="/search">fare una ricerca</a></i>.
	    </div>

<?php
if($mySession->isAdmin()) {
    // ADMIN TOOLBAR
?>
    <hr>
    <div class="clearfix">
	<a class="btn btn-danger btn-xs" href="/admin/editor.php?id=<?php echo $myQuote->ID; ?>" role="button">Modifica</a>
    </div>
<?php
}

// FOOTER
getFooter();
//
echo "<!--";
// SESSION DEBUG 
//print_r($mySession->AVP);
echo "--!>";
?>
	</div>
    </body>
</html>
