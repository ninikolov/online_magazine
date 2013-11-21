

<?php
if (empty ( $_SESSION ['LoggedIn'] ) || empty ( $_SESSION ['Username'] )) {
	
	echo "<h2>You will soon be redirected to the login page</h2>";
	echo "<meta http-equiv='refresh' content='2;" . ROOT . "' >";
} else {
	echo "<h3>Welcome " . $_SESSION ['UserType'] . " " . $_SESSION ['Username'] . " !</h3>";
}

if (isWriter ()) {
	// echo "<a href=". ROOT."/write>Write a new article</a>";
	echo "<h2>Writer Panel</h2>";
	echo "<h3>Your articles: </h3>";
	foreach ( $UserArticles as $article ) {
		echo "<div class=\"article\">";
		echo "<h4>" . htmlspecialchars ( $article->getTitle () ) . "</h4>";
		echo "</div>";
	}
	require_once 'write_form.php';
}
if (isEditor ()) {
	echo "<h2>Editor Panel</h2>";
	echo "<h3>Submitted articles: </h3>";
	foreach ( $SubmittedArticles as $Article ) {
		echo "<h4>" . htmlspecialchars ( $Article->getTitle () ) . "</h4>";
	}
}

if (isPublisher ()) {	
	echo "<h2>Publisher Panel</h2>";
	echo "<h3>Magazine users: </h3>";
	foreach ( $NonPublishers as $user ) {
		echo "<div><span>". $user->getType (). " " . $user->getName () . "</span>";
		if ($user->getType () == "subscriber") {
			?>
<form method="post"
	action="/IAPT1/member/promote_user/<?php echo $user -> getId()?>"
	name="promoteform" id="promoteform">
	<fieldset>
		<label for="newtype">Promote User:</label> <select name="newtype" id="newtype">
			<option value="writer">Writer</option>
			<option value="editor">Editor</option>
		</select> <input type="submit" name=submit id="submit" value="Submit" />
	</fieldset>
</form>
<?php
		}
		echo "</div>";
	}
}
?>
