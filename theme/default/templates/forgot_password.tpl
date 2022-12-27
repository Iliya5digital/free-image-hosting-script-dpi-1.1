<center>
<form method=post action="$root_path/forgot.php?process" class="code_table">
<font color=blue>$msg</font><br>
<table class="table_50">	
	<tr><td colspan=2><h1>Reset My Password</h1></td></tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
		<td width=40% class="simple">
			<input type="radio" name="option" value="u" checked
				onclick="javascript:obi('email').value=''; obi('username').focus();"
			>
			by username
		</td>
		<td>
			<input class=input_normal_full type=text name="username" id="username" maxlength=100 value="$_POST[username]">
		</td>
	</tr>
	<tr>
		<td class="simple">
			<input type="radio" name="option" value="e"
				onclick="javascript:obi('username').value=''; obi('email').focus();"
			>
			by email address
		</td>
		<td><input class=input_normal_full type="text" name="email" id="email" maxlength=100></td>
	</tr>
     <tr> 
      <td class="simple">* Enter Security Code</td>
      <td class="simple"> 
	   <img src="$root_path/captcha.php">
	   <br>
        <input class=input_normal type="text" name="captcha" maxlength="10">
      </td>
    </tr>	
	<tr>
		<td class=highlight_row_right colspan="2">
			<input class=button_normal type=submit value="Proceed">
		</td>
	</tr>
</table>
</form>
<script>
	document.getElementById('username').focus();
</script>
</center>