<h1>Integrated Skin Edior</h1>
<br />
<table width="100%">
<tr>
	<td width="50%">
		<form method="post" action="./admin.php?editskin">
			Please select a skin portion to edit
			<br />
			<br />
			<select size="15" name="tpl">
			$templates
			</select>
			<br />
			<br />
			<input type="submit" value="Edit selected template">
		</form>
	</td>
	<td>
		<form method="post" action="./admin.php?editskin">
			Or, select by filename (<b>advanced users only</b>)
			<br>
			<br>
			<select size="15" name="tpl">
			$files
			</select>
			<br>
			<br>
			<input type="submit" value="Edit selected file">
		</form>
	</td>
</tr>
<tr>
	<td colspan="2">
		<form method="post" action="./admin.php?editskin">
			</b>Create new template file</b> (do not include extension .tpl)
			<br />
			<br />
			<input type="text" size="100" name="tpl">
			<br />
			<br />
			<input type="submit" value="Create template">
		</form>
	</td>

</tr>
</table>