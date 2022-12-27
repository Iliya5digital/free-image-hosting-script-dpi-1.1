			<td valign=bottom>
				<! THUMB USER !>
				<table>
					<tr>
						<td class="td_gallery_thumb" align="center">
							<a href="$root_path/share.php?id=$img" target=_blank title="Preview Image"><img src='$root_path/thumb.php?id=$img' class="gallery_thumb"></a>
						</td>
					</tr>
					<tr>
						<td class="td_gallery_thumb_select">
							<input type=checkbox name="images[]" value="$image[iunique]_$image[idate]" id="ch$i">
							<span style="cursor:pointer"
								onclick="javascript:
									obi('ch$i').checked = !obi('ch$i').checked;
									this.focus();
								"
							>select</span>
							&nbsp;
							<a href="$root_path/share.php?id=$img" target=_blank title="Preview Image"><img src="$root_path/theme/$settings[theme]/images/prev_img.gif" align="center" border="0"></a>
							&nbsp;
							<a href="$root_path/misc.php?showseries=$base" title="Get Paste Code for this image">
							<img src="$root_path/theme/$settings[theme]/images/code.gif" align="center" border="0">
							</a>
						</td>
					</tr>
				</table>
			</td>

