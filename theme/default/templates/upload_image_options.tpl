<img onmouseout="javascript:set_cap('');" alt="Keep images private from images archive" onmouseover="javascript:set_cap('Keep images private from images archive');" src="$root_path/theme/$settings[theme]/images/private.gif" valign="middle"><input type=checkbox name="private" id="private" value="private" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Keep images private from images archive');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Create image border" onmouseover="javascript:set_cap('Create image border');" src="$root_path/theme/$settings[theme]/images/borderi.gif" valign="middle"><input type=checkbox name="border" id="border" value="border" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Create image border');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Create thumbnail border" onmouseover="javascript:set_cap('Create thumbnail border');" src="$root_path/theme/$settings[theme]/images/bordert.gif" valign="middle"><input type=checkbox name="bordert" id="bordert" value="bordert" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Create thumbnail border');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Watermark image" onmouseover="javascript:set_cap('Watermark image');" src="$root_path/theme/$settings[theme]/images/wm.gif" valign="middle"><input type=checkbox name="watermark" id="watermark" value="watermark" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Watermark image');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Flip image Horizontally" onmouseover="javascript:set_cap('Flip image Horizontally');" src="$root_path/theme/$settings[theme]/images/fliph.gif" valign="middle"><input type=checkbox name="fliph" id="fliph" value="fliph" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Flip image Horizontally');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Flip image Vertically" onmouseover="javascript:set_cap('Flip image Vertically');" src="$root_path/theme/$settings[theme]/images/flipv.gif" valign="middle"><input type=checkbox name="flipv" id="flipv" value="flipv" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Flip image Vertically');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Resize image" onmouseover="javascript:set_cap('Resize image');" src="$root_path/theme/$settings[theme]/images/resize.gif" valign="middle"><input type=checkbox name="resize" id="resize" value="resize" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Resize image');"
	onclick="javascript:
		if(this.checked) {
			show('resize_opts');
			obi('resizeW').focus();
			obi('resizeW').select();
		} else
			hide('resize_opts');
	"
> 
<br>

<img onmouseout="javascript:set_cap('');" alt="Rotate 90" onmouseover="javascript:set_cap('Rotate 90 &#176;');" src="$root_path/theme/$settings[theme]/images/r90.gif" valign="middle"><input type=checkbox name="rotate90" id="rotate90" value="rotate90" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Rotate 90 &#176;');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Rotate 180" onmouseover="javascript:set_cap('Rotate 180 &#176;');" src="$root_path/theme/$settings[theme]/images/r180.gif" valign="middle"><input type=checkbox name="rotate180" id="rotate180" value="rotate180" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Rotate 180 &#176;');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Rotate 270" onmouseover="javascript:set_cap('Rotate 270 &#176;');" src="$root_path/theme/$settings[theme]/images/r270.gif" valign="middle"><input type=checkbox name="rotate270" id="rotate270" value="rotate270" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Rotate 270 &#176;');"> 

&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Shear right" onmouseover="javascript:set_cap('Shear right');" src="$root_path/theme/$settings[theme]/images/shear_r.gif" valign="middle"><input type=checkbox name="shear_r" id="shear_r" value="shear_r" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Shear right');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Shear left" onmouseover="javascript:set_cap('Shear left');" src="$root_path/theme/$settings[theme]/images/shear_l.gif" valign="middle"><input type=checkbox name="shear_l" id="shear_l" value="shear_l" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Shear left');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Horizonal Scanlines" onmouseover="javascript:set_cap('Horizonal Scanlines');" src="$root_path/theme/$settings[theme]/images/sl_h.gif" valign="middle"><input type=checkbox name="scanl_h" id="scanl_h" value="scanl_h" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Horizonal Scanlines');"> 
&nbsp;
&nbsp;
&nbsp;
<img onmouseout="javascript:set_cap('');" alt="Vertical Scanlines" onmouseover="javascript:set_cap('Vertical Scanlines');" src="$root_path/theme/$settings[theme]/images/sl_v.gif" valign="middle"><input type=checkbox name="scanl_v" id="scanl_v" value="scanl_v" onmouseout="javascript:set_cap('');" onmouseover="javascript:set_cap('Vertical Scanlines');"> 

<div id="resize_opts" style="display:none">
	<br>
	<b>Image resizing options:</b>
	<br>
	<br>
	&nbsp;
	&nbsp;
	&nbsp;
	<input type="checkbox" name="asratio" 
		onclick="javascript:
			if(this.checked) {
				hide('label2');
				label1.innerHTML='Boundry box';
			} else {
				show('label2');
				label1.innerHTML='Width';
			}
			obi('resizeW').focus();
			obi('resizeW').select();
		"
	> Maintain aspect ratio
	
	&nbsp;
	&nbsp;
	<span id="label1">Width</span> <input type="text" size="4" maxlength="4" name="resizeW" id="resizeW" value="320">px
	&nbsp;
	<span id="label2">
		&nbsp;
		&nbsp;
		Height <input type="text" size="4" maxlength="4" name="resizeH" id="resizeH" value="200">px
	</span>
	<br>
	<br>
</div>

<div id="advcap" style="color:gray" class="heading_block">&gt; Options' help - please roll mouse over above image options.<br><br></div>


<script>
	function set_cap(cap) {
		if(cap =='') {
			obi('advcap').innerHTML = "&gt; Options' help - please roll mouse over above image options.<br><br>";
		} else {
			obi('advcap').innerHTML = "<b>Option help:</b> "+cap+"<br><br>";
		}
	}
</script>