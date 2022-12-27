<br>
<br>
<br>
<center>
<form method=post action="$root_path/report.php?id={$id}_{$xdate}&process" class="code_table">
<font color=blue>$msg</font><br>
<table width="70%">	
	<tr><td colspan="2"><h1>Report an Image</h1></td></tr>
	<tr>
		<td colspan="2">
			<a href="$root_path/share.php?id={$id}_{$xdate}" target="_blank" title="Click thumb to view full version"><img src="$root_path/thumb.php?id={$id}_{$xdate}" align="left" class="code_image" style="margin-right:10px;"></a>
			<div align="justify">
			<b>Dear user:</b> Reporting an image amongst a complete gallery, or an image that is associated with a 
			registered user's account, is enough. We review the entire gallery if it is associated with one, 
			and/or user profile. So, reporting multiple images from one user or one gallery will simply be ignored.
			We also track images through IP addresses and block the certain IP address if it is abusing our
			terms.
			</div>
			<br>
			<br>
			<br>
			<br>
			<br>
		</td>
	</tr>
	<tr><td colspan="2"><font color=red>$error</font></td></tr>
	<tr>
		<td width="40%" class="simple">Message (<i>optional</i>)</td>
		<td><input class="input_normal_full" type="text" name="message" id="message" maxlength="100"></td>
	</tr>
     <tr> 
      <td class="simple" valign="bottom">Enter Security Code</td>
      <td class="simple"> 
	   <img src="$root_path/captcha.php">
	   <br>
        <input class=input_normal type="text" name="captcha" id="captcha" maxlength="10">
      </td>
    </tr>	
	<tr>
		<td class="highlight_row_right" colspan="2">
			<input class="button_normal" type="submit" value="Report now">
		</td>
	</tr>
</table>
</form>
<script>
	document.getElementById('captcha').focus();
</script>
</center>
<br>
<br>
<br>