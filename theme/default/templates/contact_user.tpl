<center>
<form method=post action="$root_path/contact_user.php?id=$USR[username]&process">
<table class="table_50">	
	<tr><td colspan=2><h1>Contact $USR[username]</h1></td></tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td class="simple" width="30%">* Enter Message <br><i>Maximum 500 characters</i></td>
		<td class="simple"><textarea name="message" id="message" class="input_normal_full" rows="5">$_POST[message]</textarea></td>
	</tr>

	<tr> 
      <td class="simple">* Enter Security Code</td>
      <td class="simple"> 
	   <img src="$root_path/captcha.php">
	   <br>
        <input type="text" name="captcha" maxlength="6">
      </td>
    </tr>	
	<tr class=highlight_row_left>
		<td class=highlight_row_right colspan=2>
			<input class=button_normal type=submit value="Send Message">
		</td>
	</tr>
</table>
</form>
</center>
<script>
	document.getElementById('message').focus();
</script>