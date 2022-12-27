
<form method="post" action="$root_path/admin.php?updatemodules" class="admin_form">
<input type="hidden" name="num" value="$total_modules">
<table class="table_100">	
	<tr><td colspan=4 class="simple"><h1>Upload Modules' Settings</h1></td></tr>
	<tr><td colspan=4><font color=red>$error</font></td></tr>
	<tr bgcolor="#eeeeee">
		<td class="simple">default</td>
		<td class="simple">Module title</td>
		<td class="simple">Active / Inactive</td>
		<td class="simple">Handle multiple</td>
	</tr>
	$modules_rows	
	<tr class=highlight_row_left>
		<td class=highlight_row_right colspan=4>
			<input class=button_normal type=submit value="Update">
		</td>
	</tr>
</table>
</form>