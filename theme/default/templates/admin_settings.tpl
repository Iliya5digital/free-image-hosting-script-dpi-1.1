
<form method="post" action="$root_path/admin.php?updatesettings" class="admin_form">
<table class="table_100">	
	<tr><td colspan=2 class="simple"><h1>Global Settings</h1></td></tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td class="simple">Site Title</td>
		<td class="simple"><input class="input_normal_full" type="text" name="site_title" id="site_title" value="$settings[site_title]"></td>
	</tr>		
	<tr>
		<td class="simple">Image quality</td>
		<td class="simple">$quality % (jpeg compresion)</td>
	</tr>	
	<tr>
		<td class="simple">Thumb boundry box (WidthxHeight)</td>
		<td class="simple"><input class="input_normal" type="text" name="thumbxy" maxlength="3" size="3" value="$settings[thumbxy]"> pixels</td>
	</tr>
	<tr>
		<td class="simple">Thumb quality</td>
		<td class="simple">$thumbuality % (jpeg compresion)</td>
	</tr>
	<tr>
		<td class="simple">Display Images per page</td>
		<td class="simple"><input class="input_normal" type="text" name="imagesperpage" maxlength="3" size="3" value="$settings[imagesperpage]"> images</td>
	</tr>	
	<tr>
		<td class="simple">Outgoing Email 'From'</td>
		<td class="simple">
			Name <input class="input_normal" type="text" name="namefrom" maxlength="100" size="20" value="$settings[namefrom]">
			Email <input class="input_normal" type="text" name="emailfrom" maxlength="100" size="20" value="$settings[emailfrom]">
		</td>
	</tr>	
	<tr class=highlight_row_left>
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Update">
		</td>
	</tr>
</table>
</form>
<script>obi('site_title').focus();</script>