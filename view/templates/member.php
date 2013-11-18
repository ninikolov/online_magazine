

<?php if (empty ( $_SESSION ['LoggedIn'] ) || empty ( $_SESSION ['Username'] )) {
	echo "<h2>You will soon be redirected to the login page</h2>";
	echo "<meta http-equiv='refresh' content='2;".ROOT."' >";
} else {
	echo "<h3>Welcome " . $_SESSION ['UserType'] . " " . $_SESSION ['Username']. " !</h3>";	
}

if ($_SESSION ['UserType'] == 'writer') {
	//echo "<a href=". ROOT."/write>Write a new article</a>";
	
	echo require_once 'write_form.php';
}
?>
