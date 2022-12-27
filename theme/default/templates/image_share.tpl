<center>
	$ad1 
	<img src="$root_path/theme/$settings[theme]/images/abuse.gif" valign="middle">
	<a href="$root_path/report.php?id=$id">Report Abuse</a>
	$admin_links
	<br>
	<div class="arc_div">
	<table width="95%">
	<tr>
		<td align="left" valign="top">$plink</td>
		<td align="center">
			$gallery_link
			$author_link
			&nbsp;
			&nbsp;
			&nbsp;
			<span class="desc">
			image: <b>$size[0] x $size[1]</b>  ($filesize KB)
			<br>
			<br>
			Posted <b>$fcdate</b>
			&nbsp;
			&nbsp;
			Modofied <b>$fmdate</b>
			&nbsp;
			&nbsp;
			Last accessed <b>$fadate</b>
			<br>
			$rating
			</span>
		</td>
		<td align="right" valign="top">$nlink</td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			<br>
			$image_title
		</td>
	</tr>	
	</table>
	</div>
	<br>
	<span id="share_image"></span>
	<br />
	<br />
	$codes
	$ad2
</center>
<iframe id="fifr" style="display:none"></iframe>
<script>
	var aw = $size[0];
	var ah = $size[1];
	var pc = 'pointer';
	var dc = 'default';
	var nc = '';
	var rw = (screen.width * 0.80);
	if(aw > rw) {
		
		obi('share_image').innerHTML = "<img src='$image_path' id='iimg' width='"+rw+"' onclick='javascript:this.style.width=aw;this.style.cursor=dc;this.title=nc;'>";
		obi('iimg').title = 'Click the image to enlarge';
		obi('iimg').style.cursor=pc;
	} else {
		obi('share_image').innerHTML = "<br><br><img src='$image_path' id='iimg'>";
	}
	
</script>