
<div class="contents">
	<h3>Latest Articles</h3>
<?php
foreach ( $Map as $article ) {
	echo "<div class=\"article\">";
	echo "<h1><a href=\"" . ROOT . "/article/view/" . $article->getId () . "\">" . $article->getTitle () . "</a></h1>";
	echo "<p>" . htmlspecialchars ( $article->getBody (), ENT_COMPAT | ENT_SUBSTITUTE, "UTF-8" ) . "</p>";
	echo "</div>";
}

?>
</div>