<tr bgcolor="#eeeeee">
	<td width="60%" valign="top" style="padding:.3em;">
		<img src="$root_path/theme/$settings[theme]/images/uins.gif" align="left">
		<b>$upd[0]</b>
		<br />
		<div align="justify">
		<span class="desc">
			<b>$date</b> - 
			$upd[1]
		</span>
		</div>
	</td>
	<td>
		<a href="javascript:showhide('p$i')">Show effected files:</a>
		<div style="display:none" id="p$i"><ul type="1">$upd[2]<ul></div>
	</td>
	<td width="100px" align="center">
		<a href="$root_path/check_updates.php?install=$file">Install</a>
		<img src="$root_path/theme/$settings[theme]/images/install.gif" align="center">
	</td>
</tr>
	