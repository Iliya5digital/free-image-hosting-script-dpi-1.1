<center>
<form method=post action="$root_path/misc.php?r=$rval&reset" class="code_table">
<table class="table_50">	
	<tr>
		<td colspan=2 class="simple">
			<h1>Enter new password for account '$USR[username]'</h1>
		</td>
	</tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td class="simple" width="40%">* Enter New Password</td>
		<td>
			<img src="$root_path/theme/$settings[theme]/images/locked.gif" align="center">
			<input class=input_normal size="10" type="password" name="password" id="password" maxlength=15>
		</td>
	</tr>
	<tr class="highlight_row_left">
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Update Account">
		</td>
	</tr>
</table>
</form>
</center>
<script>
	document.getElementById('password').focus();
</script>