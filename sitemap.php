<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
	<loc>https://cittadinomedio.online/il-progetto</loc>
    </url>
<?php

include __DIR__."/common.inc.php";

$result = doQuery("SELECT ID,addDate FROM Quotes ORDER BY addDate DESC");
if($result->rowCount() > 0) {
    
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$quoteId = $row["ID"];
	$quoteDate = new DateTime($row["addDate"]);
	$myQuote = new Quote($quoteId);

	echo "\t<url>
\t\t<loc>".$myQuote->getURL()."</loc>
\t\t<lastmod>".$quoteDate->format("c")."</lastmod>
\t</url>\n";

    }
}
?>
</urlset>