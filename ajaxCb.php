<?php

include __DIR__."/common.inc.php";

if(isset($_GET["a"])) {
    $ajaxAction = preg_replace("/[^a-z0-9\-]/", "", $_GET["a"]);
} else {
    $ajaxAction = preg_replace("/[^a-z0-9\-]/", "", $_POST["a"]);
}

if($ajaxAction == "quiz") {
    $quoteId = intval($mySession->getAVP("quote-id"));
    $nonce = $_POST["nonce"];
    $risposta = intval($_POST["risposta"]);
    if($risposta > 0) {
	// Analizza risposta
	

    } else {
	// Nessuna risposta
    }
}

if(($ajaxAction == "like")||($ajaxAction == "dislike")) {
    $quoteId = intval($mySession->getAVP("quote-id"));

    if(!$mySession->getAVP("rate-$quoteId")) {
	$myQuote = new Quote($quoteId);

	if($ajaxAction == "like") {
	    $myQuote->Like++;
	    echo $myQuote->Like;
	} else {
	    $myQuote->Dislike++;
	    echo $myQuote->Dislike;
	}

	doQuery("UPDATE Quotes SET rateLike=:like,rateDislike=:dislike WHERE ID=:id",array(":like" => $myQuote->Like,":dislike" => $myQuote->Dislike, ":id" => $quoteId));

	$mySession->setAVP("rate-$quoteId", true);
    }
}

?>
