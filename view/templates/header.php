<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>The University of York -- Computer Science News</title>

<link
	href="<?php echo CSS_PATH ."/jquery-ui/jquery-ui-1.10.3.custom.css"?>"
	rel="stylesheet">
<script src="<?php echo JS_PATH ."/jquery-1.9.1.js" ?>"> </script>
<script src="<?php echo JS_PATH ."/jquery-ui-1.10.3.custom.js"?>"></script>
<script>
$(function() {
	$( "a" )
	.button();
}); 


</script>
<link rel="stylesheet" type="text/css"
	href="<?php echo CSS_PATH . "/main.css"?>">
</head>

<body>
	<div class="center main">
		<div id="topbar">
<?php
if (! array_key_exists ( 'LoggedIn', $_SESSION )) {
	echo "<small><a href=\"" . ROOT . "/member/login\">Login</a></small>";
} else {
	echo "<span>Hello " . $_SESSION ['UserType'] . " " . $_SESSION ['Username'] . "!     </span>";
	echo "<a href=\"" . ROOT . "/member/logout\">Logout</a>";
	echo "<a href=\"" . ROOT . "/member\">Member area</a>";
}
?>
			</div>
		<header>
			<img id="logo" src="<?php echo  IMAGE_PATH. "/UoYLogo.png"?>">
			<h1>Computer Science News</h1>
			<h2>Bringing you the latest from the Department and Beyond</h2>
		</header>
		<nav>

			<span>
				<?php echo "<small><a href=" . ROOT . ">Home</a></small>"?>
				<?php echo "<small><a href=" . ROOT . ">Categories</a></small>"?>
			</span>
		</nav>