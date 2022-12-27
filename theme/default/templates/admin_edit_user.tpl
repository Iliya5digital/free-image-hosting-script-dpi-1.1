<form method="post" action="$root_path/admin.php?updateuser" class="admin_form">
<input type="hidden" name="username" value="$USR[username]">
<table class="table_100">	
	<tr>
		<td colspan=2 class="simple">
			<h1>Edit User account '$USR[username]'</h1>
			Join date : $date
			<br />
			IP Address: $USR[ip]
			<br />
			<br />
			<br />
		</td>
	</tr>	
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td class="simple" width=30%">Account Status</td>
		<td class="simple">
			$locked
		</td>
	</tr>	
	<tr>
		<td class="simple">BioData</td>
		<td class="simple">
			<textarea class="input_normal_full" name="biodata" rows="5">$USR[biodata]</textarea>
		</td>
	</tr>	
	<tr>
		<td class="simple">Reset Password</td>
		<td class="simple">
			<input class="input_normal" size="10" type="text" name="password" maxlength="10">
			<i>Leave empty if not resetting password</i>
		</td>
	</tr>	
	<tr class=highlight_row_left>
		<td class="highlight_row_left">
			<img src="$root_path/theme/$settings[theme]/images/user.gif" align="center">
			<a href="$root_path/profile.php?id=$USR[username]" target="_blank">View Profile</a>
		</td>
		<td class="highlight_row_right">
			<input class=button_normal type=submit value="Update Account">
		</td>
	</tr>
</table>
</form>
