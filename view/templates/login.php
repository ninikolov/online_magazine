<?php
if (! empty ( $_SESSION ['LoggedIn'] ) && ! empty ( $_SESSION ['Username'] )) {
	?>

<h1>Member Area</h1>
<p>Thanks for logging in! You are

<b><?=$_SESSION['Username']?></b> .
</p>  

       
     <?php
} elseif (! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
	if ($UserExists) {		
		
		$_SESSION ['Username'] = $_POST ['username'];
		$_SESSION ['LoggedIn'] = 1;
		$_SESSION ['UserType'] = $UserType;
		
		echo "<h1>Success</h1>";
		echo "<p>We are now redirecting you to the member area.</p>";
		echo "<meta http-equiv='refresh' content='1;/IAPT1/' >";
	} else {
		echo "<h1>Error</h1>";
		echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
	}
} else {
	?>  
      
   <h1>Member Login</h1>

<p>
	Thanks for visiting! Please either login below, or <a
		href="register.php">click here to register</a>.
</p>

<form method="post" action="/IAPT1/member/login_check" name="loginform" id="loginform">
	<fieldset>
		<label for="username">Username:</label><input type="text"
			name="username" id="username" /><br /> <label for="password">Password:</label><input
			type="password" name="password" id="password" /><br /> <input
			type="submit" name="login" id="login" value="Login" />
	</fieldset>
</form>  
      
   <?php
}
?>  
  
</div>
</body>
</html>