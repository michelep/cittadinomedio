<?php

include __DIR__."/common.inc.php";

if(isset($_GET["a"])) {
    $ajaxAction = preg_replace("/[^a-z0-9\-]/", "", $_GET["a"]);
} else {
    $ajaxAction = preg_replace("/[^a-z0-9\-]/", "", $_POST["a"]);
}

if($ajaxAction == "quiz") {
    $quoteId = intval($mySession->getAVP("quote-id"));
    $myQuote = new Quote($quoteId);

    if($myQuote) {
        $nonce = preg_replace("/[^a-z0-9\-]/", "", $_POST["nonce"]);
        $answer = preg_replace("/[^a-z0-9\-]/", "", $_POST["answer"]);

        $result = array();

        if(strlen($answer) > 0) {
    	    // Analizza risposta
	    if($mySession->checkNonce($nonce)) {
		$ydata = yaml_parse($myQuote->Description, 0);

		$entry_score = 0;

		foreach($ydata["answer"] as $entry) {
		    $entry_id = md5($entry["text"]);
		    if(strncmp($entry_id,$answer,strlen($entry_id)) == 0) {
			$entry_score = $entry["score"];
			break;
		    }
		}
		if($entry_score > 0) {
	    	    $result["error"] = 0;
		    $result["message"] = "<strong>Ben fatto!</strong> Hai scelto la risposta giusta e conquistato ben $entry_score punti!";
		} else {
		    $result["error"] = 2;
		    $result["message"] = "<strong>Oh no!</strong> Hai scelto la risposta sbagliata.";
	        }
    	    } else {
		$result["error"] = 2;
		$result["message"] = "<strong>Ooops!</strong> Invalid nonce.. try refreshing the page (hit F5)...";
	    }
	} else {
	    // Nessuna risposta
	    $result["error"] = 1;
	    $result["message"] = "<strong>Hey!</strong> Non hai selezionato alcuna risposta!";
	}
    } else {
	$result["error"] = 2;
	$result["message"] = "<strong>Ooops!</strong> Internal error occours.";
    }
    echo json_encode($result);
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
