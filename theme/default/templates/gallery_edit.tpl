<center>
<form method=post action="$root_path/mygalleries.php?edit=$gid&save">
<font color=blue>$msg</font><br>
<table class="table_50">	
	<tr><td colspan=2 class="simple">Edit Gallery - <b>$gal[title]</b></td></tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td width=40% class="simple">*Gallery Title</td>
		<td class="simple"><input class=input_normal_full type=text name="title" maxlength=100 value="$gal[title]"></td>
	</tr>
	<tr>
		<td class="simple">Gallery Description</td>
		<td class="simple"><textarea name="description" class=input_normal_full>$gal[description]</textarea></td>
	</tr>
	<tr>
		<td width=40% class="simple">Tags, search keywords</td>
		<td class="simple"><input class="input_normal_full" type=text name="tags" maxlength=100 value="$gal[tags]"></td>
	</tr>
	<tr>
		<td width=40% class="highlight_row_left" valign="top">
			Gallery Password
		</td>
		<td class="highlight_row_left">
			<b>$already</b>
			<ul type="1">
				<li> <input type="radio" name="option" value="intact" checked onclick="javascript:validate_pinput(this.value);"> Make no changes to password
				<li> <input type="radio" name="option" value="remove" onclick="javascript:validate_pinput(this.value);"> Remove password <i>if exists</i>
				<li> <input type="radio" name="option" value="new" onclick="javascript:validate_pinput(this.value);"> Set new password
			</ul>
			<div id="pdiv" style="display:none">
			<img src="$root_path/theme/$settings[theme]/images/locked.gif" align="center">
			Enter new Password 
			&nbsp;
			<input class="input_normal" size=10 type=password name="password" id="password" maxlength=10>
			</div>
			<br />
			<br />
			<script>
				function validate_pinput(cval) {
					var pobj = obi('password');
					switch(cval) {
						case 'intact': pobj.value=''; hide('pdiv'); break;
						case 'remove': pobj.value=''; hide('pdiv'); break;
						case 'new': 
							show('pdiv');
							pobj.value=''; 
							pobj.focus();
							break;
						
					}
				}
			</script>

		</td>
	</tr>
	<tr class=highlight_row_left>
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Save Changes">
		</td>
	</tr>
</table>
</form>
</center>
<script>
	document.getElementById('title').focus();
</script>