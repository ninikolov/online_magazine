


<div class="contents">
 <?php
	/*
	 * if ($Article == null) { echo "<meta http-equiv='refresh' content='0;" . ROOT . "' >"; }
	 */
	echo "<h2>" . $Article->getTitle () . "</h2>";
	echo "<p>";
	if ($Article->getType() == "column_article") {
		echo "<b>Column: </b>" . $Article->getColumnName() . " ";
	} elseif ($Article->getType() == "review") {
		echo "<b>Reviw with rating: </b>" . $Article->getRating() . " ";
	} else {
		echo "<b>Article </b> ";
	}
	echo "<b>Written by:</b>" . htmlspecialchars ( $Article->getWriter () ) . " on ";
	echo "" . (new DateTime ( $Article->getDate () ))->format ( 'Y-m-d' ) . ".";
	echo "<b> Keywords: </b>" . htmlspecialchars ( $Article->getKeyWords () ) . "; <b>Likes:</b> ";
	echo "" . htmlspecialchars ( $Article->getLikesCount () ) . "</p>";
	echo "<hr color=\"#5A8039\" size=\"1px\" />";
	
	echo "<img src=\"" . ROOT . $Article->getImage () . "\">";
	
	if (isEditor () && $Article->getStatus () == "submitted") {
		echo "<a href=\"" . ROOT . "/article/toggle_review/" . $Article->getId () . "\">Set to under review</a>";
	} elseif (isEditor () && $Article->getStatus () == "under_review") {
		require_once 'edit_form.php';
		require_once 'article_status_form.php';
	}
	if ($Article->getType () == "column") {
		echo "<p>" . $Column . "</p>";
	}
	echo "<p>" . $Article->getBody () . "</p>";
	
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
	
	foreach ( $Comments as $key => $Comment ) {
		echo "<div class=\"comment\"><p>" . htmlspecialchars ( $Comment->getBody (), ENT_COMPAT | ENT_SUBSTITUTE, "UTF-8" ) . "</p>";
		echo "<p><b>Written by: </b>" . $Users [$key]->getName () . " on " . $Comment->getDate () . "</p>";
		echo "</div>";
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
	?>
	
</div>
