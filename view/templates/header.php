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
/* $(function() {
	$( "a" )
	.button();
});  */

$(document).ready(function () {	
	$('nav li').hover(
		function () {
			$('ul', this).stop().slideDown(200);

		}, 
		function () {
			$('ul', this).stop().slideUp(200);			
		}
	);
	
});



</script>
<link rel="stylesheet" type="text/css"
	href="<?php echo CSS_PATH . "/main.css"?>">
<style type="text/css">
body {
	
}

#background {
	position: fixed;
	top: 45%;
	left: 0;
	right: 0;
	width: 42%;
	opacity: 0.07;
	filter: alpha(opacity =  7);
}

.overlay {
	position: absolute;
	left: 0px;
	background: url('<?php echo ROOT ?>/images/bg.png');
	bottom: 4px;
	padding: 4px;
}
</style>
</head>

<body>
	<div id="background"></div>

	<img src="<?php echo  IMAGE_PATH. "/shield.png"?>" id="background"
		class="center">
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
		<hr color="#5A8039" size="2px" />
		<header>
			<img id="logo" src="<?php echo  IMAGE_PATH. "/UoYLogo.png"?>">

			<h2>Bringing you the latest from the Department and Beyond</h2>
			<h1>Computer Science News</h1>
		</header>
		<hr color="#5A8039" size="2px" />
		<nav>
			<ul>
				<li><a href="<?php  echo ROOT ?>">Home</a></li>
				<li><a href="<?php echo ROOT . "/latest" ?>">Latest</a></li>
				<li><a href="<?php  echo ROOT ?>">Categories</a><span
					class="ui-icon ui-icon-carat-1-s"></span>
					<ul>
						<li><a href="#">Item 01</a></li>
						<li><a href="#" class="selected">Item 02</a></li>
						<li><a href="#">Item 03</a></li>
					</ul></li>
				<li><a href="<?php echo ROOT . "/about" ?>">About</a></li>
			</ul>
		</nav>
		<hr color="#5A8039" size="1px" />