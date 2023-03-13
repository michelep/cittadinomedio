<?php

include __DIR__."/common.inc.php";

// Set the content type header - in this case image/jpeg
header('Content-Type: image/jpeg');

$im = @imagecreatefromjpeg("./img/banner.jpg");

if($im) {
    if(isset($_GET["id"])) {
	$id = intval($_GET["id"]);

	$result = doQuery("SELECT Title FROM Quotes WHERE ID=:id",array(":id" => $id));
	if($result->rowCount() > 0) {
	    $row = $result->fetch(PDO::FETCH_ASSOC);

	    $title = wordwrap(stripslashes($row["Title"]),20,"\n",false);

	    $white = imagecolorallocate($im, 255, 255, 255);
	    $font = __DIR__."/fonts/Rubik-Black.ttf";

	    imagettftext($im, 30, 0, 100, 220, $white, $font, $title);
	}
    }
    imagejpeg($im);

    // Free up memory
    imagedestroy($im);
}

?>