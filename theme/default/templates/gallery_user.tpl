<form name="gfx" method="post" action="$root_path/mygalleries.php?update=$gid">
<input type=hidden id="act" name="act" value="none">
<input type=hidden id="act" name="sgid" value="$gid">
<table class="table_100">
	<tr>
		<td class="td_gallery_left">
			<span class="heading_block"><b>MY GALLERIES</b></span>
			<br>
			<div class="user_gallery_left_div" nowrap>
				$g_list
				&nbsp;
				<img src="$root_path/theme/$settings[theme]/images/galu.jpg">
				<a href="$root_path/mygalleries.php?id=0"><i>Uncategories images</i></a>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
			</div>
		</td>
		<td class="td_gallery_right">
			<table width="100%">
				<tr>
					<td colspan= "$settings[imagesperrow]">
						<table width=100%>
						<tr>
							<td width="50%"><h1>$cgal[title]</h1></td>
							<td align="right" class="simple">
								$prev_link
								&nbsp;
								&nbsp;
								$pages_text
							</td>
						</tr>
						</table>
						<br>
						$top_message
					</td>
				</tr>
				<tr>
				$g_images
				</tr>
			</table>
		</td>
		
	</tr>
	<tr>
		<td colspan=2 align="right" class="highlight_row_left">
			<script>
			function check_all(ch) {
				var nF = document.getElementsByTagName('input');
				var nI = document.getElementsByTagName('input').length;
				var ix;
				for(ix=0; ix<nI; ix++) {
					if(nF[ix].type == 'checkbox') 
						nF[ix].checked=ch;
					
				}		
				return true;	
			}
			</script>
			<a name="bottom"></a>
			<a href="#bottom" onclick="check_all(true)">Select All</a>
			&nbsp;
			&nbsp;
			<a href="#bottom" onclick="check_all(false)">Select None</a>
			&nbsp;
			|
			&nbsp;
			<input type=button value="Get Paste Code" onclick="javascript:obi('act').value='c';gfx.submit();">
			&nbsp;
			<input type=button title="The seleccted (one) image will be set as icon of the gallery for public" value="Set Gal. Image" onclick="javascript:obi('act').value='s';gfx.submit();">
			&nbsp;
			<input type=button title="Set as you profile picture" value="Set Avatar" onclick="javascript:obi('act').value='a';gfx.submit();">
			&nbsp;
			<input type=button value="Delete selected" onclick="javascript:obi('act').value='d';gfx.submit();">
			<br>
			<br>
			Move selected to
			$galleries_combo
			<input type=button value="Move" onclick="javascript:obi('act').value='m';gfx.submit();">
			<br />
			<br />
			$pages_text
			&nbsp;
		</td>
	</tr>
</table>
</form>