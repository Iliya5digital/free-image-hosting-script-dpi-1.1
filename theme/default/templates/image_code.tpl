<table class="code_table">
	<tr>
		<td class="td_code_image">
			<a href="$root_path/share.php?id=$id" target="_blank"><img src='$root_path/thumb.php?id=$id' class="code_image"></a>
		</td>
		<td class="td_code_fields">
			<table class="table_100">
			<tr>
				<td class="simple">BBCode for Forum</td>
				<td><input onClick="javascript:sel_txt(this);" class="code_box" type=text value="[url=$root_path/share.php?id=$id][img]$root_path/thumb.php?id={$id}[/img][/url]"></td>
			</tr>
			<tr>
				<td class="simple">HTML Code for Site</td>
				<td><input onClick="javascript:sel_txt(this);" class="code_box" type=text value='<a href="$root_path/share.php?id=$id"><img src="$root_path/thumb.php?id=$id" border="0"></a>'></td>
			</tr>
			<tr>
				<td class="simple">Hotlink for Forum</td>
				<td><input onClick="javascript:sel_txt(this);" class="code_box" type=text value="[url=$root_path/share.php?id=$id][img]$root_path/image.php?id={$id}&{$gif}[/img][/url]"></td>
			</tr>
			<tr>
				<td class="simple">Hotlink for Site</td>
				<td><input onClick="javascript:sel_txt(this);" class="code_box" type=text value='<a href="$root_path/share.php?id=$id"><img src="$root_path/image.php?id={$id}&{$gif}" border="0"></a>'></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<br>
