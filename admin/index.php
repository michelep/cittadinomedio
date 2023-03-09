<?php

include __DIR__."/../common.inc.php";

?>
<!doctype html>
<html lang="it" class="h-100">
<?php 
// HEADER
getHeader();

if(!$mySession->isAdmin()) {
    $mySession->setAVP("is-admin",true);
}

//
?>
    <body class="d-flex h-100 text-center text-white bg-dark">
	<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
	    <header class="mb-auto">
		<div>
		    <h3 class="float-md-start mb-0 logo"><a href="/">Cittadino Medio - Administrator</a></h3>
		</div>
	    </header>
	    <main>
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">
		    <div class="input-group">
			<input id="filter" type="text" class="form-control" placeholder="Type here..."/>
		    </div>
		</div>
		<div class="clearfix">&nbsp;</div>
		<table class="table table-bordered">
		    <thead>
			<tr>
			    <th scope="col">ID</th>
			    <th scope="col">Titolo</th>
			    <th scole="col">Daily</th>
			    <th scope="col">Like</th>
			    <th scope="col">Dislike</th>
	    		</tr>
		    </thead>
		    <tbody class="searchable">
<?php
$result = doQuery("SELECT ID,dailyViews FROM Quotes ORDER BY dailyViews DESC;");
if($result) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$id = $row["ID"];
	$myQuote = new Quote($id);
?>
			<tr>
			    <td><b><?php echo $id; ?></b></td>
			    <td><a href="/admin/editor.php?id=<?php echo $id; ?>"><?php echo $myQuote->Title; ?></a></td>
			    <td class="text-info"><?php echo $row["dailyViews"]; ?></td>
			    <td class="text-success"><?php echo $myQuote->Like; ?></td>
			    <td class="text-danger"><?php echo $myQuote->Dislike; ?></td>
			</tr>
<?php
    }
}	
?>
		    </tbody>
		</table>
		<div class="clearfix">
		    <a class="btn btn-primary btn-xs" href="editor.php" role="button">Aggiungi una nuova pillola</a><br/>
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
