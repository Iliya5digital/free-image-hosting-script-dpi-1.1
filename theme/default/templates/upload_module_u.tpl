<img src="$root_path/theme/$settings[theme]/images/urlbg.gif" valign="middle">
&nbsp;
URL
&nbsp;
<input type=text name="u_$current_day{N}" id="u_{N}" class="field_url" 
	onchange="javascript:
		var temp = obi('u_{N}').value.split('/');
		if(obi('use_labels').checked)
			obi('ucap{N}').value=temp[temp.length-1];
	"
>
&nbsp;
Title
&nbsp;
<input type="text" name="ucap{N}" id="ucap{N}" size="20" maxlength="100">
<img src="$root_path/theme/$settings[theme]/images/clear.gif" valign="middle"
	style="cursor:pointer"
	alt="Clear the title"
	onclick="javascript:obi('ucap{N}').value='';"
>
<br />
