<?php
if (isset ( $CreatedUser )) {
	if ($CreatedUser) {
		?>
<h1>Successfully created subscriber account <?php echo $username ?>.</h1>
<h4>You will now be redirected to the login page to login with your new
	account.</h4>
<?php } else {?>
<h1>Username already taken.</h1>
<?php
	}
} else {
	
	if (loggedIn ()) {
		?>
<h1>You are logged in.</h1>
<?php
	} else {
		?>

<h1>Register form</h1>

<p>Please enter your details below to register.</p>

<form method="post" action="<?php echo ROOT. "/member/create_user"?>"
	name="reg_form" id="reg_form">
	<fieldset>
		<label for="username">Username:</label><input type="text"
			name="username" id="username" /><br /> <label for="password">Password:</label><input
			type="password" name="password" id="password" /><br /> <input
			type="submit" name="register" id="register" value="Register" />
	</fieldset>
</form>
<?php
	}
}
?>