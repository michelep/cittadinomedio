<?php

include_once __DIR__.'/config/config.inc.php';

require __DIR__ . '/vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$sessionId = session_id();

if(empty($sessionId)) {
    session_start();
    $sessionId = session_id();
}

$mySession = new Session($sessionId);

$DB = OpenDB();

function doQuery($query,$params=array()) {
    global $DB;

    try {
	$prepare = $DB->prepare($query);
	if(empty($params)) {
    	    $prepare->execute();
	} else {
	    $prepare->execute($params);
	}
	return $prepare;
    } catch(PDOException $e) {
	die("DB query error! $query => ".$e->getMessage());
    }
}

function OpenDB() {
    global $CFG;

    $connectionString = 'mysql:host='.$CFG["dbHost"].';dbname='.$CFG["dbName"];

    try {
	//Connect to database.
	$db = new PDO($connectionString, $CFG["dbUsername"], $CFG["dbPassword"]);
    } catch(PDOException $e) {
	die("DB connect error! ".$e->getMessage());
    }

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
}

function stringShortner($string, $length=60) {
    $text = trim(str_replace(array("\r","\n", "\t", "\""), ' ', strip_tags($string)));

    $words = explode(' ', $text, $length + 1);
    if(strlen($text) > $length) {
	while(strlen($text) > $length) {
    	    array_pop($words);
    	    $text = implode(' ', $words);
	}
	$text = trim(implode(' ', $words));
    }
    return $text."...";
}


function getFooter() {
    echo "<footer class=\"mt-auto text-white-50\">
	<p>Created with <i class=\"fa fa-heart fa-fw\"></i> under <a href=\"https://creativecommons.org/licenses/by-sa/4.0/deed.it\" target=\"_new\">CC BY-SA</a> - <a href=\"/privacy\">Privacy Policy</a></p>
    </footer>
    <script src=\"/js/jquery.min.js\"></script>
    <script>window.jQuery</script>
    <script src=\"/js/bootstrap.bundle.min.js\"></script>
    <script src=\"/js/common.js\"></script>";
}

function getHeader($quote=false) {
    global $CFG;

    if($quote) {
	if($quote->Type == 2) {
	    $description = stringShortner("Mettiti alla prova! ".$quote->Title,70);
	} else {
	    $description = stringShortner($quote->Description,200);
	}
	$keywords = $quote->Keywords;
	$title = stringShortner("Cittadino Medio - ".$quote->Title,70);
	$url = $quote->getURL();
	$id = $quote->ID;
	$author = $quote->getAuthor();

    } else {
	$description = "Un progetto per sensibilizzare la cittadinanza alla privacy, cybersecurity e anonimato in Rete";
	$keywords = "privacy, cybersecurity, anonimato, democrazia";
	$title = "Cittadino Medio";
	$url = $CFG["baseUrl"];
	$id = 0;
	$author = "Cittadino Medio";
    }

    echo "<head>
	<meta charset=\"utf-8\">
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
	<meta name=\"description\" content=\"$description\">
	<meta name=\"author\" content=\"$author\">
	<meta name=\"keywords\" content=\"$keywords\">
	<meta name=\"url\" content=\"$url;\">

	<meta http-equiv=\"Cache-Control\" content=\"no-cache, no-store, must-revalidate\" />
	<meta http-equiv=\"Pragma\" content=\"no-cache\" />
	<meta http-equiv=\"Expires\" content=\"0\" />

	<title>$title</title>

	<link href=\"/style/bootstrap.min.css\" rel=\"stylesheet\" crossorigin=\"anonymous\">

	<link rel=\"sitemap\" type=\"application/xml\" title=\"Sitemap\" href=\"/sitemap\">

	<link rel=\"apple-touch-icon\" href=\"/apple-touch-icon.png\" sizes=\"180x180\">
	<link rel=\"icon\" href=\"/favicon-32x32.png\" sizes=\"32x32\" type=\"image/png\">
	<link rel=\"icon\" href=\"/favicon-16x16.png\" sizes=\"16x16\" type=\"image/png\">
	<link rel=\"icon\" href=\"/favicon.ico\">

	<meta property=\"og:title\" content=\"".textTrim($title,80)."\" />
	<meta property=\"og:description\" content=\"".textTrim($description,160)."\" />
	<meta property=\"og:url\" content=\"$url\" />
	<meta property=\"og:type\" content=\"website\" />
	<meta property=\"og:site_name\" content=\"Cittadino Medio\" />
	<meta property=\"og:image\" content=\"https://cittadinomedio.it/banner/$id\" />

	<meta name=\"twitter:title\" content=\"".textTrim($title,80)."\" />
	<meta name=\"twitter:description\" content=\"".textTrim($description,160)."\" />
	<meta name=\"twitter:card\" content=\"summary_large_image\" />
	<meta name=\"twitter:site\" content=\"@mediocittadino\" />
	<meta name=\"twitter:creator\" content=\"@mediocittadino\" />
	<meta name=\"twitter:image\" content=\"https://cittadinomedio.it/banner/$id\" />

	<link href=\"/style/font-awesome.min.css\" rel=\"stylesheet\">
	<link href=\"/style/font-awesome-animation.min.css\" rel=\"stylesheet\">
	<link href=\"/style/common.css\" rel=\"stylesheet\">
    </head>";
}

function isSelect($val_a, $val_b) {
    if($val_a == $val_b) return "selected";
}

function APG($nChar=5) {
    $salt = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ0123456789";
    srand((double)microtime()*1000000); 
    $i = 0;
    $pass = '';
    while ($i <= $nChar) {
	$num = rand() % strlen($salt);
        $tmp = substr($salt, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

class Session {
    var $ID;
    var $AVP=array();
    var $nonce;

    function __construct($ID) {
	if(!empty($_SESSION["AVP"])) {
	    $this->AVP = unserialize($_SESSION["AVP"]);
	}
	if(!empty($_SESSION["nonce"])) {
	    $this->nonce = $_SESSION["nonce"];
	}
    }

    function __destruct() {
	$_SESSION["nonce"] = $this->nonce;
    }

    public function getAVP($key) {
	if(in_array($key,array_keys($this->AVP))) {
	    return $this->AVP[$key];
	} 
	return false;
    }

    public function setAVP($key,$value) {
	$this->AVP[$key] = $value;
	$_SESSION["AVP"] = serialize($this->AVP);
    }

    function isAdmin() {
	if($this->getAVP("is-admin")) {
	    return true;
	}
    }

    function getNonce() {
	$nonce = md5(APG(10));
	$this->nonce = $nonce;
	return $nonce;
    }

    function checkNonce($nonce) {
	$tmp_nonce = $this->nonce;
	$this->nonce = false;
	if(strcmp($nonce,$tmp_nonce)==0) {
	    return true;
	} else {
	    return false;
	}
    }
}

class Quote {
    var $ID;
    var $Title;
    var $Description;
    var $permaUrl;
    var $Keywords;
    var $Tags;
    var $Like;
    var $Dislike;
    var $Author;
    var $Type;

    function __construct($ID=false) {
	if($ID) {
	    $result = doQuery("SELECT ID,Title,Description,PermaURL,Author,Type,rateLike,rateDislike FROM Quotes WHERE ID=:id",array(":id" => $ID));
	} else {
	    $result = doQuery("SELECT ID,Title,Description,PermaURL,Author,Type,rateLike,rateDislike FROM Quotes ORDER BY RAND() LIMIT 1");
	}
	if($result) {
	    $row = $result->fetch(PDO::FETCH_ASSOC);

	    $this->ID = $row["ID"];
	    $this->Title = trim(stripslashes($row["Title"]));
	    $this->Description = stripslashes($row["Description"]);
	    $this->Author = $row["Author"];
	    $this->Type = intval($row["Type"]);
	    $this->Like = $row["rateLike"];
	    $this->Dislike = $row["rateDislike"];
    
	    if(empty($row["permaUrl"])) {
		// genera Perma URL
		$permaUrl = strtolower($this->Title);
		$permaUrl = str_replace(array(" il "," la "," per "," lo "," gli "," del "," e "," i "," in "," che ")," ",$permaUrl);
		$permaUrl = str_replace(array(".",","),"",$permaUrl);
		$permaUrl = preg_replace('/[^a-z0-9]+/i', '-', $permaUrl);
		// Aggiorna sul DB
		doQuery("UPDATE Quotes SET PermaURL=:permaUrl WHERE ID=:id",array(":permaUrl" => $permaUrl,":id" => $this->ID));
		// OK
		$this->permaUrl = $permaUrl;
	    } else {
	        $this->permaUrl = stripslashes($row["PermaURL"]);
	    }

	    $result = doQuery("SELECT ID,Tag FROM Tags AS t1 INNER JOIN QuoteTags AS t2 ON t1.ID=t2.tagId WHERE t2.quoteId=:id",array(":id" => $this->ID));
	    if($result) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		    $tag_id = $row["ID"];
		    $tag_value = $row["Tag"];
		    $this->Tags[$tag_id] = $tag_value;
		}
	    }
	}
    }

    // Ritorna la scitta per il pulsante di approfondimento pillola
    function echoType() {
	switch($this->Type) {
	    case 0: // Pillola di approfondimento
		echo "Vorrei approfondire";
		break;
	    case 1: // Pillola di comportamento sbagliato
		echo "Come posso migliorare?";
		break;
	    default:
		break;
	}
    }

    function getAuthor() {
	if($this->Author) {
	    return $this->Author;
	} else {
	    return "Cittadino Medio";
	}
    }

    function getURL() {
	global $CFG;

	return $CFG["baseUrl"]."/q/".$this->permaUrl;
    }
}

function prepareForTwitter($quote) {
    $quote = str_replace(array("cittadino medio"),array("#cittadinomedio"),$quote);
    return urlencode($quote);
}

function textTrim($text,$len) {
    $string = strip_tags(html_entity_decode($text));
    if(strlen($string) <= $len) {
        return $string;
    } else {
        $final_string = "";
        $words = explode(" ", $string);
        foreach( $words as $value ){
            if( strlen($final_string . " " . $value) < $len) {
                if(!empty($final_string)) $final_string .= " ";
                $final_string .= $value;
            } else {
                break;
            }
        }
        $final_string .= "...";
    }
    return $final_string;
}

function sendTwitter($message) {
    global $CFG;

    $connection = new TwitterOAuth($CFG["API_KEY"], $CFG["API_KEY_SECRET"], $CFG["ACCESS_TOKEN"], $CFG["ACCESS_TOKEN_SECRET"]);
    $status = $connection->post("statuses/update", ["status" => $message]);
    if ($connection->getLastHttpCode() == 200) {
	return true;
    } else {
	return false;
    }
}


?>