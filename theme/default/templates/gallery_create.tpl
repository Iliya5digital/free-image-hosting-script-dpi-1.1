<center>
<form method=post action="$root_path/mygalleries.php?process" class="code_table">
<font color=blue>$msg</font><br>
<table class="table_50">	
	<tr><td colspan=2 class="simple"><b>Create New Gallery</b></td></tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td width=40% class="simple">*Gallery Title</td>
		<td class="simple"><input class=input_normal_full type=text name="title" maxlength=100 value="$_POST[title]"></td>
	</tr>
	<tr>
		<td class="simple">Gallery Description</td>
		<td class="simple"><textarea name="description" class=input_normal_full>$_POST[description]</textarea></td>
	</tr>
	<tr>
		<td width=40% class="simple">Tags, search keywords</td>
		<td class="simple"><input class="input_normal_full" type=text name="tags" maxlength=100 value="$_POST[tags]"></td>
	</tr>
	<tr>
		<td width=40% class="highlight_row_left" valign="top">
			Set Gallery Password
		</td>
		<td class="highlight_row_left">
			<input class="input_normal" size=10 type=password name="password" maxlength=10>
			<br>
			<i>
				<li> Leave empty to make gallery public, or
				<br />
				<li> Set gallery password for viewing
			</i>			
		</td>
	</tr>
	<tr> 
      <td class="simple">*Enter Security Code</td>
      <td class="simple"> 
	   <img src="$root_path/captcha.php">
	   <br>
        <input type="text" name="captcha" maxlength="6">
      </td>
    </tr>	
	<tr class=highlight_row_left>
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Create">
		</td>
	</tr>
</table>
</form>
</center>
<script>obi('title').focus();</script>