      <!--[if IE]>
      <br>
      <input type="button" value="W+" onclick="javascript:inc_width()">
      <input type="button" value="W-" onclick="javascript:dec_width()">
      <input type="button" value="H+" onclick="javascript:inc_height()">
      <input type="button" value="H-" onclick="javascript:dec_height()">
      <br>
      <br>
	<![endif]--> 
	<object
        classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
        codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,79,0"
        id="dpi_drawing_api"
        width="450" height="300"
        
      >
        <param name="movie" value="$root_path/dpi_drawing_api.swf">
        <param name="bgcolor" value="#FFFFFF">
        <param name="quality" value="high">
        <param name="allowscriptaccess" value="samedomain">
        <embed
          type="application/x-shockwave-flash"
          pluginspage="http://www.macromedia.com/go/getflashplayer"
          name="dpi_drawing_api"
          width="450" height="300"
          src="$root_path/dpi_drawing_api.swf"
          bgcolor="#FFFFFF"
          quality="high"
          swliveconnect="true"
          allowscriptaccess="samedomain"
          id="dpi_drawing_api"
        >
          <noembed>
          </noembed>
        </embed>
      </object>
	<script>
		function inc_height() {
			var oh = obi('dpi_drawing_api').offsetHeight;
			oh += 20;
			obi('dpi_drawing_api').style.height= oh+'px';			
		}
		function dec_height() {
			var oh = obi('dpi_drawing_api').offsetHeight;
			if(oh > 100) {
				oh -= 20;
				obi('dpi_drawing_api').style.height= oh+'px';			
			}
		}	
		function inc_width() {
			var oh = obi('dpi_drawing_api').offsetWidth;
			oh += 20;
			obi('dpi_drawing_api').style.width= oh+'px';			
		}
		function dec_width() {
			var oh = obi('dpi_drawing_api').offsetWidth;
			if(oh > 100) {
				oh -= 20;
				obi('dpi_drawing_api').style.width= oh+'px';			
			}
		}			
	</script>