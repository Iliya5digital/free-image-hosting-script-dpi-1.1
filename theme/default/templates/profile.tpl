<table class="table_100">
	<tr>
		<td class="simple" valign="top">
			<div class="arc_div">
			<img src="$avatar_url" align="left" style="margin-right:15px;margin-bottom:10px;">
			<h1>$USR[username]</h1>
			<img src="$root_path/theme/$settings[theme]/images/mail.gif" align="center">
			<a href="$root_path/contact_user.php?id=$USR[username]">Send to $USR[username]</a>
			(Joined $USR[date])
			<br>
			<br>
			<div class="desc">
				$USR[biodata]
			</div>
			</div>
			<br />
			<br />
			<center><h1>Galleries by $USR[username]</h1></center>
			<br />
			<br />
			$galleries
			
		</td>
		
	</tr>
</table>
