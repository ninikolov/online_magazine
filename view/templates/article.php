



 <?php
	/*
	 * if ($Article == null) { echo "<meta http-equiv='refresh' content='0;" . ROOT . "' >"; }
	 */
	echo "<img src=\"" . $Article->getImage () . "\">";
	echo "<h2>" . $Article->getTitle () . "</h2>";
	echo "<p>" . $Article->getType () . "</p>";
	if ($Article->getType () == "column") {
		echo "<p>" . $Column . "</p>";
	}
	echo "<p>" . $Article->getBody () . "</p>";
	echo "<p>" . $Article->getKeyWords () . "</p>";
	echo "<p>" . $Article->getWriter () . "</p>";
	echo "<p>" . "Likes: " . $Article->getLikesCount () . "</p>";
	if (isSubscriber ()) {
		if ($CanLike) {
			echo "<a href=\"" . ROOT . "/article/like/" . $Article->getId () . "\">" . "Like " . "</a>";
		} else {
			?>
<a>You've alreadly liked this article</a>

<?php
		}
	}
	
	foreach ( $Comments as $Comment ) {
		echo "<p class=\"contents\">" . htmlspecialchars ( $Comment->getBody (), ENT_COMPAT | ENT_SUBSTITUTE, "UTF-8" ) . "</p>";
	}
	
	if (isSubscriber ()) {
		?>

<form method="post"
	action="<?php echo ROOT."/article/comment/".$Article->getId () ?>"
	name="comment" id="comment">
	<textarea name="commentbody" id="commentbody"
		class="text ui-widget-content ui-corner-all" rows="5" cols="30"></textarea>
	<input type="submit" name="submit" id="submit" value="Submit comment" />
</form>

<?php
	} else {
	}
	
	