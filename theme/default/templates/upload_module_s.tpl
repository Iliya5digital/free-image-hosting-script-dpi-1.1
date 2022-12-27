<img src="$root_path/theme/$settings[theme]/images/filebg.gif" align="middle">
&nbsp;
Image
&nbsp;
<input type="file" name="f_single" id="f_single" class="field_file"
	onchange="javascript:
		show_preview('img_single',this.value);
		var temp = obi('f_single').value.split('\\\\');
		if(obi('use_labels').checked)
			obi('cap_single').value = temp[temp.length-1];		
	"
>
<img id="img_single" class="preview_img" style="display:none" valign="middle" title="Selected Image Preview">
&nbsp;
Title
&nbsp;
&nbsp;
<input type="text" name="cap_single" id="cap_single" size="20" maxlength="100">
<img src="$root_path/theme/$settings[theme]/images/clear.gif" valign="middle"
	style="cursor:pointer"
	alt="Clear the title"
	onclick="javascript:obi('cap_single').value='';"
>
<br>
<br>
<br>


