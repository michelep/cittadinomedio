<?php

include __DIR__."/../common.inc.php";

?>
<!doctype html>
<html lang="it" class="h-100">
    <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />

	<title>Cittadino Medio - Administrator</title>

	<link href="/style/bootstrap.min.css" rel="stylesheet">

	<link rel="apple-touch-icon" href="/apple-touch-icon.png" sizes="180x180">
	<link rel="icon" href="/favicon-32x32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="/favicon-16x16.png" sizes="16x16" type="image/png">
	<link rel="icon" href="/favicon.ico">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/ui/trumbowyg.min.css" integrity="sha512-iw/TO6rC/bRmSOiXlanoUCVdNrnJBCOufp2s3vhTPyP1Z0CtTSBNbEd5wIo8VJanpONGJSyPOZ5ZRjZ/ojmc7g==" crossorigin="anonymous" />

	<link href="/style/font-awesome.min.css" rel="stylesheet">
	<link href="/style/bootstrap-tagsinput.css" rel="stylesheet">
	<link href="/style/common.css" rel="stylesheet">
    </head>

    <body class="d-flex h-100 text-center text-white bg-dark">
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
	    <header class="mb-auto">
		<div>
		    <h3 class="float-md-start mb-0 logo"><a href="/">Cittadino Medio - Administrator</a></h3>
		</div>
	    </header>

	    <main>
<?php
if(isset($_POST["action"])) {
    if($_POST["action"] == "edit") {
	$id = $_POST["id"];
	$title = $_POST["title"];
	$description = $_POST["description"];
	$type = intval($_POST["type"]);

	if($id > 0) {
	    // UPDATE
	    doQuery("UPDATE Quotes SET Title=:title,Description=:description,Type=:type WHERE ID=:id",array(":title" => $title,":description" => $description,":Type" => $type,":id" => $id));

	    echo "<div class=\"alert alert-success\" role=\"alert\">
		Pillola $id AGGIORNATA con successo!
	    </div>";
	} else {
	    // CREATE NEW
	    doQuery("INSERT INTO Quotes(Title,Description,Type,addDate) VALUES (:title,:description,:Type,NOW())",array(":title" => $title,":description" => $description, ":Type" => $type));
	    $id = $DB->lastInsertId();
	    echo "<div class=\"alert alert-success\" role=\"alert\">
		CREATA nuova pillola con ID <a href=\"/admin/editor.php?id=$id\">$id</a>
	    </div>";
	}
	doQuery("DELETE FROM QuoteTags WHERE quoteId=:id",array(":id" => $id));

	foreach($_POST["tags"] as $null => $tag_value) {
	    $tag_value = strtolower(trim($tag_value));
	    $result = doQuery("SELECT ID FROM Tags WHERE Tag LIKE :tag",array(":tag" => $tag_value));
	    if($result->rowCount() > 0) {
		// TAG individuato e già presente
		$row = $result->fetch(PDO::FETCH_ASSOC);
		$tag_id = $row["ID"];
	    } else {
		// Nuovo TAG
	        doQuery("INSERT INTO Tags(Tag) VALUES (:tag)",array(":tag" => $tag_value));
		$tag_id = $DB->lastInsertId();
	    }
	    doQuery("INSERT INTO QuoteTags(quoteId,tagId,addDate) VALUES (:id,:tag_id,NOW())",array(":id" => $id,":tag_id" => $tag_id));
	}
    }
}

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    $myQuote = new Quote($id);

    echo "<h3>Edit \"$myQuote->Title\"</h3>";
} else {
    echo "<h3>New quote</h3>";
}
?>
		<form method="POST">
		    <input type="hidden" name="action" value="edit">
		    <input type="hidden" name="id" value="<?php echo $myQuote->ID; ?>">
		    <input type="hidden" name="nonce" value="<?php echo $mySession->getNonce(); ?>">
		    <div class="mb-3">
			<label for="titleInput" class="form-label">Titolo</label>
			<input type="text" class="form-control" id="titleInput" name="title" placeholder="Titolo" value="<?php echo $myQuote->Title; ?>">
		    </div>
		    <div class="mb-3">
			<label for="descriptionTextarea" class="form-label">Descrizione</label>
			<textarea class="form-control" id="descriptionTextarea" name="description" rows="10"><?php echo $myQuote->Description; ?></textarea>
		    </div>
		    <div class="mb-3">
			TAGs: <select id="quoteTags" class="form-input bootstrap-tagsinput" name="tags[]" multiple data-role="tagsinput">
<?php
foreach(array_values($myQuote->Tags) as $value) {
    echo "<option value=\"$value\">$value</option>";
}
?>
			</select>
		    </div>
		    <div class="mb-3">
			Type: <select class="form-control" id="typeSelect" name="type">
			    <option value="0" <?php echo isSelect($myQuote->Type,0); ?>>Approfondimento</option>
			    <option value="1" <?php echo isSelect($myQuote->Type,1); ?>>Comportamento sbagliato</option>
			    <option value="2" <?php echo isSelect($myQuote->Type,2); ?>>Quiz</option>
			</select>
		    </div>
		    <input type="submit" value="Salva">
		    <a href="<?php echo $myQuote->getURL(); ?>" class="button button-danger">Guarda questa pillola</a>
		</form>
	    </main>
	    <footer class="mt-auto text-white-50">
		<p>Created with <i class="fa fa-heart fa-fw"></i> and <a href="/privacy">Privacy Policy</a></p>
	    </footer>
	    <script src="/js/jquery.min.js"></script>
	    <script>window.jQuery</script>
	    <script src="/js/bootstrap.bundle.min.js"></script>
	    <script src="/js/bootstrap-tagsinput.min.js"></script>
	    <!-- WYSIWYG Editor -->
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js" integrity="sha512-sffB9/tXFFTwradcJHhojkhmrCj0hWeaz8M05Aaap5/vlYBfLx5Y7woKi6y0NrqVNgben6OIANTGGlojPTQGEw==" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/langs/it.min.js" integrity="sha512-6QSIn+7o9d9Oh3WmGz7rkvy6vXTj52tTtTu2lIK/jCC5xI8qWSbpIvaALoX70pO30IKZM74X22nxNNinkcuNWg==" crossorigin="anonymous"></script>
	    <script>
		$("#descriptionTextarea").trumbowyg();
		$("#quoteTags").tagsinput({
		    freeInput: true,
		    trimValue: true
		});
	    </script>
	    <script src="/js/common.js"></script>
	</div>
    </body>
</html>
