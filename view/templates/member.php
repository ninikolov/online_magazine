
<div class="member_panel">
<?php
if (empty ( $_SESSION ['LoggedIn'] ) || empty ( $_SESSION ['Username'] )) {
	echo "<h2>You will soon be redirected to the login page</h2>";
	echo "<meta http-equiv='refresh' content='2;" . ROOT . "' >";
} else {
	echo "<h3>Welcome " . $_SESSION ['UserType'] . " " . $_SESSION ['Username'] . " !</h3>";
}

if (isset ( $SuccessMessage )) {
	echo '<script type="text/javascript">', 'alert_success_message("' . $SuccessMessage . '");', '</script>';
} elseif (isset ($ErrorMessage)) {
	echo '<script type="text/javascript">', 'alert_error_message("' . $ErrorMessage . '");', '</script>';
}
if (isWriter ()) {
	// echo "<a href=". ROOT."/write>Write a new article</a>";
	echo "<h2>Writer Panel</h2>";
	echo "<h3>Your articles: </h3>";
	echo "<table border=\"0\"> <tr><th>Title</th><th>Status</th></tr>";
	foreach ( $UserArticles as $article ) {
		echo "<tr><td class=\"article\">";
		echo "<a href=\"" . ROOT . "/article/view/" . $article->getId () . "\">" . htmlspecialchars ( $article->getTitle () ) . "</a>";
		echo "</td><td>";
		if ($article->getStatus () == "submitted") {
			echo "Submitted";
		} elseif ($article->getStatus () == "awaiting_changes") {
			echo "Awaiting changes, go to article page";
		} elseif ($article->getStatus () == "under_review") {
			echo "Under review";
		} elseif ($article->getStatus () == "published") {
			echo "Published";
		}
		echo "</td></tr>";
	}
	echo "</table>";
	require_once 'write_form.php';
}
if (isEditor ()) {
	echo "<h2>Editor Panel</h2>";
	echo "<h3>Submitted articles waiting to be reviewed: </h3>";
	echo "<table border=\"0\"> <tr><th>Title</th><th>Status</th></tr>";
	foreach ( $SubmittedArticles as $article ) {
		echo "<tr><td class=\"article\">";
		echo "<a href=\"" . ROOT . "/article/view/" . $article->getId () . "\">" . htmlspecialchars ( $article->getTitle () ) . "</a>";
		echo "</td><td>";
		if ($article->getStatus () == "submitted") {
			echo "Submitted";
		} elseif ($article->getStatus () == "awaiting_changes") {
			echo "Awaiting changes, go to article page";
		} elseif ($article->getStatus () == "under_review") {
			echo "Under review";
		} elseif ($article->getStatus () == "published") {
			echo "Published";
		}
		echo "</td></tr>";
	}
	echo "</table>";
	
	echo "<h3>Your edit History: </h3>";
	echo "<table>";
	foreach ( $EditHistory as $article ) {
		echo "<tr><td class=\"article\">";
		echo "<a href=\"" . ROOT . "/article/view/" . $article->getId () . "\">" . htmlspecialchars ( $article->getTitle () ) . "</a>";
		echo "</td><td>";
		if ($article->getStatus () == "submitted") {
			echo "Submitted";
		} elseif ($article->getStatus () == "awaiting_changes") {
			echo "Awaiting changes, go to article page";
		} elseif ($article->getStatus () == "under_review") {
			echo "Under review";
		} elseif ($article->getStatus () == "published") {
			echo "Published";
		}
		echo "</td></tr>";
	}
	echo "</table>";
}

if (isPublisher ()) {
	echo "<h2>Publisher Panel</h2>";
	echo "<h3>Magazine users: </h3>";
	echo "<table border=\"1\"> <tr><th>User</th><th>Type</th></tr>";
	foreach ( $NonPublishers as $user ) {
		echo "<tr><td class=\"article\">" . $user->getName () . "</td><td>" . $user->getType () . "</td>";
	}
	echo "</table>";
}
?>
<?php

if (isPublisher ()) {
	?>
	<form method="post" action="/IAPT1/member/promote_user"
		name="promoteform" id="promoteform">
		<fieldset>
			<label for="user">Name</label><select name="user" id="user">
				<?php
	foreach ( $NonPublishers as $user ) {
		if ($user->getType () == "subscriber") {
			echo "<option value=\"" . $user->getId () . "\">" . $user->getName () . "</option>";
		}
	}
	?>
			</select><label for="newtype">Promote User</label> <select
				name="newtype" id="newtype">
				<option value="writer">Writer</option>
				<option value="editor">Editor</option>
			</select> <input type="submit" name=submit id="submit" value="Submit" />
		</fieldset>
	</form>
</div>
<?php
} else {
}

?>

