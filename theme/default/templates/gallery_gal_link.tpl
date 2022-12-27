&nbsp;
<img src="$root_path/theme/$settings[theme]/images/gal.jpg" align="center">
<a href="$root_path/mygalleries.php?id=$gal[id]">$gal[title]</a>
<br>
&nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<a title="Delete this gallery" href="javascript:if(confirm('Are you sure you want to delete gallery? entitled:\\n\\n$gal[title]\\n\\n\\nIMPORTANT: All images (if any) attached to this gallery will also be deleted.'))location.replace('$root_path/mygalleries.php?delete=$gal[id]');"><img border="0" src="$root_path/theme/$settings[theme]/images/delete.jpg" align=center></a>
&nbsp;
<a title="Edit gallery" href="$root_path/mygalleries.php?edit=$gal[id]"><img border="0" src="$root_path/theme/$settings[theme]/images/edit.jpg" align=center></a>
&nbsp;
&nbsp;
<a title="Preview gallery" href="$root_path/gallery.php?id=$gal[id]" target="_blank"><img border="0" src="$root_path/theme/$settings[theme]/images/preview.jpg" align=center></a>
<br>
<br>
<br>
