
<form method="post" action="$root_path/admin.php?updatesettings" class="admin_form">
<table class="table_100">	
	<tr><td colspan=2 class="simple"><h1>Flood Control Settings</h1></td></tr>	
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td class="simple" width=30%">Turn Uploading ON/OFF</td>
		<td class="simple">
			<span id="currof">currently set</span>
			$allowuploading 
		</td>
	</tr>	
	<tr>
		<td class="simple">Maximum images per attempt</td>
		<td class="simple"><input class="input_normal" type="text" name="maxnumimages" maxlength="2" size="3" value="$settings[maxnumimages]"> images</td>
	</tr>	
	<tr>
		<td class="simple">Maximum filesize</td>
		<td class="simple">
			<input class="input_normal" type="text" name="maxfilesize" maxlength="4" size="3" value="$settings[maxfilesize]">
			$filesizeguage
		</td>
	</tr>	
	<tr>
		<td class="simple">Interval between next upload</td>
		<td class="simple"><input class="input_normal" type="text" name="upload_interval" maxlength="3" size="3" value="$settings[upload_interval]"> seconds</td>
	</tr>	
	<tr>
		<td class="simple">User to user contact Interval</td>
		<td class="simple"><input class="input_normal" type="text" name="contact_interval" maxlength="3" size="3" value="$settings[contact_interval]"> seconds</td>
	</tr>	
	<tr class=highlight_row_left>
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Update">
		</td>
	</tr>
</table>
</form>
