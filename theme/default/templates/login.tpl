<center>
<form method=post action="$root_path/login.php?process" class="code_table">
<input type=hidden name=ref value="$ref">
<font color=blue>$msg</font><br>
<table class="table_50">	
	<tr><td colspan=2><h1>USER LOGIN</h1></td></tr>
	<tr><td colspan=2><font color="red">$error</font></td></tr>
	<tr>
		<td width=50% class="simple">Username</td>
		<td><input class="input_normal_full" type="text" name="username" id="username" maxlength=100 value="$_POST[username]"></td>
	</tr>
	<tr>
		<td class="simple">Password</td>
		<td><input class="input_normal_full" type="password" name="password" maxlength=100></td>
	</tr>
	$login_track_images
	<tr class="highlight_row_right">
		<td align="left">
			If you forgot your password, 
			<a href="$root_path/forgot.php"><b>click here</b></a>
			to reset the password.
		</td>
		<td>
			<input class="button_normal" type="submit" value="Proceed logging in">
		</td>
	</tr>
</table>
<br>
<br>
</form>
<script>
	document.getElementById('username').focus();
</script>
</center>