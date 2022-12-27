<img src="$root_path/theme/$settings[theme]/images/filebg.gif" align="middle">
&nbsp;
Image
&nbsp;
<input type="file" name="f_{N}" id="f_{N}" class="field_file"
	onchange="javascript:
		show_preview('img_m{N}',this.value);
		var temp = obi('f_{N}').value.split('\\\\');
		if(obi('use_labels').checked)
			obi('cap{N}').value = temp[temp.length-1];
	"
	size="10"
>
<img id="img_m{N}" class="preview_img" style="display:none" valign="middle" title="Selected Image Preview">
&nbsp;
Title
&nbsp;
<input type="text" name="cap{N}" id="cap{N}" size="20" maxlength="100">
<img src="$root_path/theme/$settings[theme]/images/clear.gif" valign="middle"
	style="cursor:pointer"
	alt="Clear the title"
	onclick="javascript:obi('cap{N}').value='';"
>
<br>

