

<?php if (empty ( $_SESSION ['LoggedIn'] ) || empty ( $_SESSION ['Username'] )) {
	echo "<h2>You will soon be redirected to the login page</h2>";
	echo "<meta http-equiv='refresh' content='2;".ROOT."' >";
} else {
	echo "<h3>Welcome " . $_SESSION ['UserType'] . " " . $_SESSION ['Username']. " !</h3>";	
}

if (isWriter()) {
	//echo "<a href=". ROOT."/write>Write a new article</a>";
	
	foreach ( $UserArticles as $article ) {
		echo "<div class=\"article\">";
		echo "<h2>" . htmlspecialchars ( $article->getTitle () ) . "</h2>";
		//echo "<p>" . htmlspecialchars ( $article->getBody (), ENT_COMPAT | ENT_SUBSTITUTE, "UTF-8" ) . "</p>";
		echo "</div>";
	}
	echo require_once 'write_form.php';
}
?>
