
<script>
$( document ).ready(function() {
	$("#edit_panel a[href]").button();
});
</script>

<div class="contents">
 <?php
	displayMessage ( array () );
	
	if (true) {
		echo "<h2>" . $Article->getTitle () . "</h2>";
		echo "<p>";
		if ($Article->getType () == "column_article") {
			echo "<b>Column: </b>" . $Article->getColumnName () . " ";
		} elseif ($Article->getType () == "review") {
			echo "<b>Reviw with rating: </b>" . $Article->getRating () . " ";
		} else {
			echo "<b>Article </b> ";
		}
		echo "<b>Written by:</b>" . htmlspecialchars ( $Article->getWriter () ) . " on ";
		echo "" . $Article->getDate () . ".";
		echo "<b> Keywords: </b>" . htmlspecialchars ( $Article->getKeyWords () ) . "; <b>Likes:</b> ";
		echo "" . htmlspecialchars ( $Article->getLikesCount () ) . "</p>";
		echo "<hr color=\"#5A8039\" size=\"1px\" />";
		echo "<div id='panel'>";
		echo "<img src=\"" . ROOT . $Article->getImage () . "\">";
		if ((isEditor () && $Article->getStatus () == "submitted")) {
			echo "<div id='edit_panel'>";
			echo "<h3>Article Edit Options: </h3>";
			echo "<small><a href=\"" . ROOT . "/article/toggle_review/" . $Article->getId () . "\">Set article to 'Under review'</a></small>";
			echo "</div>";
		} elseif (isEditor () && ($Article->getStatus () == "under_review" || $Article->getStatus () == "awaiting_changes")) {
			echo "<div id='edit_panel'>";
			echo "<h3>Article Edit Options: </h3>";
			require_once 'edit_form.php';
			if ($Article->getFeatured () == "0") {
				echo "<small><a href=\"" . ROOT . "/article/feature/" . $Article->getId () . "\">Feature article</a></small>";
			} else {
				echo "<small><a href=\"" . ROOT . "/article/unfeature/" . $Article->getId () . "\">Remove from featured</a></small>";
			}
			require_once 'article_status_form.php';
			echo "</div>";
		} elseif ($Article->checkIfWriter () && $Article->getStatus () == "awaiting_changes") {
			echo "<div id='edit_panel'>";
			echo "<h3>Article Edit Options: </h3>";
			require_once 'edit_form.php';
			echo "</div>";
		} elseif (isEditor()) {
			echo "<div id='edit_panel'>";
			echo "<h3>Article Options: </h3>";
			if ($Article->getFeatured () == "0") {
				echo "<small><a href=\"" . ROOT . "/article/feature/" . $Article->getId () . "\">Feature article</a></small>";
			} else {
				echo "<small><a href=\"" . ROOT . "/article/unfeature/" . $Article->getId () . "\">Remove from featured</a></small>";
			}
			echo "</div>";
		}
		echo "</div>";
		echo "<div id='article_body'>";
		if ($Article->getType () == "column") {
			echo "<p>" . $Column . "</p>";
		}
		
		echo "<p>" . $Article->getBody () . "</p>";
		echo "</div>";
		echo "<p>" . "<b>Likes:</b> " . $Article->getLikesCount () . "</p>";
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
	}
	?>
	
</div>
