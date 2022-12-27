
<form method="post" action="$root_path/admin.php?updatesettings" class="admin_form">
<table class="table_100">	
	<tr><td colspan=2 class="simple">
			<h1>SEO Settings</h1>
			Make sure you have Apache Rewrite Engine set ON on server
			</td>
	</tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>

	<tr>
		<td class="simple" width="30%">SEO Urls enabled</td>
		<td class="simple">$seourls </td>
	</tr>	
	<tr class=highlight_row_left>
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Update">
		</td>
	</tr>
</table>
</form>