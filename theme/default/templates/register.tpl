<center>
<form name=csreg method="post" action="$root_path/register.php?process" class="code_table">
<table class=table_50>	
	<tr><td colspan=2 class="simple"><br><h1>NEW USER REGISTRATION</h1></td></tr>
	<tr><td colspan=2><font color=red>$error</font></td></tr>
	<tr>
      <td class="simple" width="30%">Username</td>
      <td class="simple"> 
        * <input class=input_normal_full type="text" value="$_POST[username]" name="username" id="username" maxlength="15">
      </td>
    </tr>
    <tr> 
      <td class="simple">E-mail</td>
      <td class="simple"> 
        * <input class=input_normal_full type="text" name="email" value="$_POST[email]" maxlength="100">
      </td>
    </tr>
    <tr> 
      <td class="simple">Public Profile / bio-data</td>
      <td class="simple"> 
        <textarea class=input_normal_full rows=4 name="biodata">$_POST[biodata]</textarea>
      </td>
    </tr>   
     <tr> 
      <td class="simple">Enter Security Code</td>
      <td class="simple"> 
	   <img src="$root_path/captcha.php">
	   <br>
        * <input class=input_normal_full type="text" name="captcha" maxlength="10">
      </td>
    </tr>
    <tr> 
      <td colspan=2 class=highlight_row_right> 
        <input class=button_normal type="submit" value="Finish Registration">
      </td>
    </tr>
  </table>
<br>
<br>
</form>
</center>
<script>obi('username').focus();</script>