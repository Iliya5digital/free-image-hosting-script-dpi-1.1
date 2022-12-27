<br />
<br />
<script type="text/javascript">var ie = 0;</script>
<!--[if IE]>
<script type="text/javascript">ie = 1;</script>
<![endif]--> 
<div id="xpgb" align="center" style="display:none"></div>
<script>
	var divarr = new Array($m_jsarray);

	function show_except(csh,stype) {
		for(var i=0; i<divarr.length; i++) 
			if(divarr[i] == csh)
				show(csh);
			else
				hide(divarr[i]);
				
		obi('typ').value = stype;
	}
	function show_preview(iid,filename) {
		if(ie==0) return false;
		var fl = 'file:///' + str_replace('\\\\','/',filename);
		obi(iid).src=fl;
		show(iid);
		return true;
	}
	var pimg = new Image();
	pimg.src = '$root_path/theme/$settings[theme]/images/pgb.gif';	
</script>
<form name="frx" method="post" action="$root_path/upload.php" enctype="multipart/form-data">
	
	<div id="all">
	<input type="hidden" name="typ" id="typ" value="$settings[default_module]">
	<table class="table_100">
	<tr>
		<td class="td_upload_choice" colspan="2">
			$m_buttons
		</td>
	</tr>
	<tr>
	<td class="td_upload_box">
		<i class="desc">Supported Image Formats: jpeg, png, gif, wbmp, xbm, xpm, jpg, jpe</i>
		<br>
		<input type="checkbox" id="use_labels" checked> Automatically add title to images
		<br>
		<br>
		$m_wrappers
		<br>
		<span class="heading_block"><li type="square"><b>Image Enhancement Options</b> (rollover option to see detail)</span>
		<br>
		$upload_image_options
		<span class="heading_block"><li type="square"><b>Upload to specific gallery</b></span>
		$select_gallery
		<br>
		<br>
		<input type="button" value="Process Now &gt;&gt;" onclick="javascript:start_uploading();">
	</td>
	<td class="td_upload_right">
		$upload_right_box
	</td>
	</table>
	</div>
</form>
<script>
	function start_uploading() {
		hide('all');
		show('xpgb');
		obi('xpgb').innerHTML= "<br /><img src='$root_path/theme/$settings[theme]/images/pgb.gif'> <br /><br />Please wait while processing your request..<br /><b>Do not refresh and/or close the window while you see the flashing proressbar.";
		document.frx.submit();
	}

</script>
