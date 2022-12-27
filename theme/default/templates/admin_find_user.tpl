<form method="post" action="$root_path/admin.php?edituser" class="admin_form">
	<font color=red>$error</font>
	<br />
	<br />

	<b>Quick Edit User Account</b>
	<input type="radio" name="option" value="u" checked
				onclick="javascript:obi('email').value=''; obi('username').focus();"
	>
	by username
	<input class=input_normal type=text name="username" size="10" id="username" maxlength=100>
	<input type="radio" name="option" value="e"
		onclick="javascript:obi('username').value=''; obi('email').focus();"
	>
	by email address
	<input class=input_normal type="text" name="email" size="10" id="email" maxlength=100>	
	<input type="submit" value="Edit">
</form>
<script>
	document.getElementById('username').focus();
</script>