


		<div class="slider">Slider</div>
		<div>
			<div class="contents">
			<h3>Latest Articles</h3>
<?php
foreach ( $Map as $article ) {
	echo "<div class=\"article\">";
	echo "<h2>" . htmlspecialchars ( $article->getTitle () ) . "</h2>";
	echo "<p>" . htmlspecialchars ( $article->getBody (), ENT_COMPAT | ENT_SUBSTITUTE, "UTF-8" ) . "</p>";
	echo "</div>";
}

?>

<?php
echo "<p><a href=\"" . ROOT . "/home/test\">" . $test_action . "</a></p>";
?>
</div>