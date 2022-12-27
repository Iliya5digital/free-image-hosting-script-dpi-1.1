<center>
<form method=post action="$root_path/gallery.php?id=$gid&log">
<font color=blue>$msg</font><br>
<table class="table_50">	
	<tr>
		<td colspan=2 class="simple">
			<h1>$cgal[title]</h1>
		</td>
	</tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td colspan=2>
			<br>
			<div class="msgbox">
			Gallery author has set a password to view contents of this gallery.
			If you have the password please enter below, or <a href="$root_path/contact_user.php?id=$cgal[username]">Click here to message the author to request password.</a>
			</div>
			<br>
			<br>
		</td>
	</tr>
	<tr>
		<td class="simple" width="40%">» Enter Password</td>
		<td>
			<img src="$root_path/theme/$settings[theme]/images/locked.gif" align="center">
			<input class=input_normal size="10" type="password" name="password" id="password" maxlength=10>
		</td>
	</tr>
	<tr class="highlight_row_left">
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Login to view">
		</td>
	</tr>
</table>
</form>
</center>
<script>
	document.getElementById('password').focus();
</script>