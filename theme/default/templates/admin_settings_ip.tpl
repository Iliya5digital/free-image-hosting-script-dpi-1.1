<form method="post" action="$root_path/admin.php?updatesettings" class="admin_form">
<table class="table_100">	
	<tr><td colspan=2 class="simple"><h1>IP Banning</h1></td></tr>
	<tr>
		<td class="simple" width="30%">Blocked IP addresses</td>
		<td class="simple">
			Please separate by comma
			<br>
			<textarea class="input_normal_full" name="blockedips" id="blockedips" rows="10">$settings[blockedips]</textarea>
		</td>
	</tr>			
	<tr class=highlight_row_left>
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Update">
		</td>
	</tr>
</table>
</form>
<script>
	document.getElementById('blockedips').focus();
</script>