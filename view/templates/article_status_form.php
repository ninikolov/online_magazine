

<form method="post"
	action="/IAPT1/article/update_status/<?php echo $Article -> getId()?>"
	name="loginform" id="loginform">
	<fieldset>
		<label for="status">Change status:</label> <select name="status"
			id="status">
			<option value="awaiting_changes">Awating changes</option>
			<option value="published">Published</option>
		</select> <input type="submit" name=submit id="submit" value="Submit" />
	</fieldset>
</form>
