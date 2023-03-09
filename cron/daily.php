<?php
/* THIS SCRIPT SHOULD BE RUNNED EACH DAY */

include __DIR__."/../common.inc.php";

$dailyMessages = [
    "La pillola più vista ieri è \"%title%\", con %views% visitatori. Curioso? %url%",
    "Fantastico! \"%title%\" è stata la pillola più vista ieri! Vuoi dare un'occhiata anche tu? %url%",
    "Buongiorno care e cari follower! La pillola più vista di ieri è stata \"%title%\". Potrebbe interessarvi? %url%",
    "E' stata una faticaccia ma %views% visitatori, ieri, hanno letto \"%title%\". %url%",
    "** BLIP! BLOP! ** Messaggio automatico: la pillola più vista ieri è stata \"%title%\" ed è qui: %url%",
    "Cittadine e cittadini medi di terra e di mare, l'ora della pillola più vista di ieri è giunta! Eccola: \"%title%\"! %url%",
];

/* most viewed of the day */
$result = doQuery("SELECT ID,dailyViews FROM Quotes ORDER BY dailyViews DESC LIMIT 1");
if($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);

    $id = $row["ID"];
    $myQuote = new Quote($id);
    $views = $row["dailyViews"];

    // Daily tweet!
    $dailyMessage = str_replace(array("%title%","%views%","%url%"),array($myQuote->Title,$views,$myQuote->getURL()),$dailyMessages[rand(0,count($dailyMessages))]);

    foreach($myQuote->Tags as $tag_id => $tag_value) {
	$dailyMessage .= " #".$tag_value;
    }

    sendTwitter($dailyMessage);

    /* Add "dailytop" tag to most viewed quote of the day */
    doQuery("DELETE FROM QuoteTags WHERE tagId=14");
    doQuery("INSERT INTO QuoteTags(quoteId,tagId,addDate) VALUES (:id,14,NOW())",array(":id" => $id));

    /* Add to DailyStats */
    doQuery("INSERT IGNORE INTO DailyStats(dayDate,quoteId,Views) VALUES (CURDATE(),:id,:views)",array(":id" => $id,":views" => $views));
}

/* Cleanup dailyViews */
doQuery("UPDATE Quotes SET dailyViews=0");

?>
