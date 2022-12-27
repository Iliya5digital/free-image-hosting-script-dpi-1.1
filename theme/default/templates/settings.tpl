<center>
<form method="post" action="$root_path/settings.php?update" class="code_table">

<font color=blue>$msg</font><br>
<table class="table_50">	
	<tr><td colspan=2 class="simple"><b>Edit Account Settings</b></td></tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td class="simple">Bio Data<br>(<i>Publically available to viewers</i>)</td>
		<td class="simple"><textarea name="biodata" id="biodata" rows="5" class="input_normal_full">$logged_user[biodata]</textarea></td>
	</tr>
	<tr>
		<td width=30% class="simple">New password</td>
		<td class="simple">
			<input class="input_normal" type="password" name="password" maxlength=100">
			<b>IMPORTANT:</b> Leave empty if not resetting password
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
			<input class=button_normal type=submit value="Update My account">
		</td>
	</tr>
</table>
</form>
<script>obi('biodata').focus();</script>
</center>