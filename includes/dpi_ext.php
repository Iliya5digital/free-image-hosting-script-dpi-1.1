<?

	/*
	+----------------------------------------------------------+
	|
	|	DPI 			(Lightweight ImageHosting Script)
	|	By			image-host-script.com
	|	Support		support@image-host-script.com
	|	Version		1.1
	|
	|	Developer		Ali Imran Khan Shirani
	|
	|	Copyright		Clixint Technologies International
	|				www.clixint.com
	|
	+----------------------------------------------------------+
	*/		
	
	
	#updated Oct 22, 2008
	# added - scanlines_v
	# added - scanlines_h
	# added - shear_r
	# added - shear_l

	#updated Sep 03, 2008
	# added - gd_flip_h
	# added - gd_flip_v

	#updated May 27, 2008
	# added - gd_set_bg
	
	
	function dpi_supported($file) { 
		$DPI_IMAGE_TYPES = Array(1,2,3,10);
		$size = @getimagesize($file);
		if(!$size) return false;
		return in_array($size[2],$DPI_IMAGE_TYPES) ? $size[2] : false; 
	}
	

	function scanlines_h(&$image,$line_gap=1,$opacity=100) {
		$w = imagesx($image);
		$h = imagesy($image);
		$ret = imagecreatetruecolor($w,$h);
		$line_gap++;
		
		for ($y = 1; $y < $h; $y += $line_gap) 
			imagecopymerge($ret, $image, 0, $y, 0, $y, $w, 1,$opacity);
		
		return $ret;
	}
	function scanlines_v(&$image,$line_gap=1,$opacity=100) {
		$w = imagesx($image);
		$h = imagesy($image);
		$ret = imagecreatetruecolor($w,$h);
		$line_gap++;
		
		for ($x = 1; $x < $w; $x += $line_gap) 
			imagecopymerge($ret, $image, $x, 0, $x, 0, 1, $h,$opacity);
		
		return $ret;
	}	
	function shear_r(&$image,$pers=50,$bgcolor="FFFFFF") {
		$w = imagesx($image);
		$h = imagesy($image);
		$ret = imagecreatetruecolor($w,$h);
		gd_bar($ret,0,0,$w,$h,$bgcolor);
		$z=0;
		$pers = 100-$pers;
		$pers /=100;
		$p1 = $h * $pers;
		
		$gap = $p1 / $w;
		
		for ($x = 0; $x < $w; $x++,$z+=$gap) 
			imagecopyresampled ( 
				$ret, 	#resource dst_im, 
				$image,	#resource src_im, 
				$x, 		#int dstX, 
				($h-($h-$z))/2, 		#int dstY, 
				$x,		#int srcX, 
				0,		#int srcY, 
				1,		#int dstW, 
				$h-$z,	#int dstH, 
				1,		#int srcW, 
				$h		#int srcH
			);
		
		return $ret;
	}		
	function shear_l(&$image,$pers=50,$bgcolor="FFFFFF") {
		$w = imagesx($image);
		$h = imagesy($image);
		$ret = imagecreatetruecolor($w,$h);
		gd_bar($ret,0,0,$w,$h,$bgcolor);
		$z=0;
		$pers = 100-$pers;
		$pers /=100;
		$p1 = $h * $pers;
		
		$gap = $p1 / $w;
		
		for ($x = $w-1; $x >= 0; $x--,$z+=$gap) 
			imagecopyresampled ( 
				$ret, 	#resource dst_im, 
				$image,	#resource src_im, 
				$x, 		#int dstX, 
				($h-($h-$z))/2, 		#int dstY, 
				$x,		#int srcX, 
				0,		#int srcY, 
				1,		#int dstW, 
				$h-$z,	#int dstH, 
				1,		#int srcW, 
				$h		#int srcH
			);
		
		return $ret;
	}
	
	function load_dpi_image($name) {
		$name = str_replace(".jpg","",$name);
		@list($u,$d) = @explode("_",$name);
		
		$decdate = @hexdec($d);
		return @imagecreatefromstring(load_file(IMAGE_DIR.'/images/'.@date("Y/F/d",$decdate)."/$name.jpg"));
	}
	
	
	function gd_flip_h(&$image) {
		$ret = gd_newimage(imagesx($image),imagesy($image));
		$w = imagesx($image);
		$h = imagesy($image);
		for ($x = 0; $x < $w; $x++) 
			imagecopy($ret, $image, $w - $x - 1, 0, $x, 0, 1, $h);
		
		return $ret;
	}
	function gd_flip_v(&$image) {
		$ret = gd_newimage(imagesx($image),imagesy($image));
		$w = imagesx($image);
		$h = imagesy($image);
		for ($x = 0; $x < $h; $x++) 
			imagecopy($ret, $image, 0, $h - $x - 1, 0, $x, $w, 1);
		return $ret;
	}	
	function gd_rotate(&$img,$ang=90,$col="FFFFFF") {
		$col = gd_hexgd($img,$col);
		return imagerotate($img,$ang,$col);
	}	
	
	function gd_3db_watermark(&$img,$filepath) {
		
		$w = imageSX($img);
		$h = imageSY($img);
		$img2 = imagecreatefromstring(load_file($filepath));
		$ww = imageSX($img2);
		$wh = imageSY($img2);
		$x = ($w-$ww)/2;
		$y = ($h-$wh)/2;
		
		imagecopy($img, $img2, $x, $y, 0, 0, $ww, $wh); 
		return $img;
	}
	function gd_set_bg(&$img,$color="FFFFFF") {
		$w = imageSX($img);
		$h = imageSY($img);
		$img2 = gd_newimage($w,$h);
		gd_bar($img2,0,0,$w,$h,$color);
		imagecopy($img2, $img, 0, 0, 0, 0, $w, $h); 
		return $img2;
	}
	function gd_fit_bg(&$img,$fit=100,$color="FFFFFF") {
		$w = imageSX($img);
		$h = imageSY($img);
		$img2 = gd_newimage($fit,$fit);
		gd_bar($img2,0,0,$fit,$fit,$color);
		
		$x = ($fit-$w)/2;
		$y = ($fit-$h)/2;
		
		imagecopy($img2, $img, $x,$y, 0, 0, $w, $h); 
		return $img2;
	}	
    function gd_hexgd(&$image,$hex) {
		$R = hexdec(@$hex{0}.@$hex{1});
		$G = hexdec(@$hex{2}.@$hex{3});
		$B = hexdec(@$hex{4}.@$hex{5});

		return imagecolorallocate ($image, $R, $G, $B);    
    }  
    function gd_bar(&$image,$x=0,$y=0,$width,$height,$color="FFFFFF") {
		return imagefilledrectangle ($image, $x, $y, $x+$width, $y+$height, gd_hexgd($image,$color));
    }

    function gd_text(&$image,$x,$y,$text,$color="000000",$font=2) {

		//return imagettftext ( $image, 14, 0, $x, $y, gd_hexgd($image,$color), "./arial.ttf", $text);

		return imagestring ($image, $font, $x, $y, $text, gd_hexgd($image,$color));	
    }
	function gd_loadfont($fname) {
		$f = "./templates/gdf/$fname.gdf";
		if(!file_exists($f)) {
			echo "file not found - $f<br />";
			return false;
		}
		$fn = @imageloadfont($f);
		if($fn === FALSE) return false;
		return $fn;
	}    
	function gd_textwidth($font=1,$text) {
		$ret= 0;
		if($text=='') return 0;
		return (imagefontwidth($font) * strlen($text));// - (imagefontwidth($font)/2);
	}
	function gd_textheight($font=1) {
		return imagefontheight($font);
	}	
    function gd_width(&$image) {
		return imagesx($image);
    }
    function gd_height(&$image) {
		return imagesy($image);
    }    

    function gd_imagewidth($fname) {
		list($width, $height) = getimagesize($fname); 		
		return $width;
    }
    function gd_imageheight($fname) {
		list($width, $height) = getimagesize($fname); 		
		return $height;
    }       
    function gd_copy(&$image,$x,$y,$w,$h) {
		$ret=imagecreatetruecolor($w, $h); 
		imagecopy($ret,$image, 0, 0, $x, $y, $w, $h);    
		
		return $ret; 
    }
    function gd_paste(&$from,$to,$x=0,$y=0) {
		return imagecopymerge($to, $from, $x, $x, 0, 0, imagesx($from), imagesy($from), 100);      
    }
    function gd_resize(&$image,$w,$h) {
		$ret=@imagecreatetruecolor($w, $h); 
		@imagecopyresampled ($ret,$image, 0, 0, 0, 0, $w, $h, imagesx($image), imagesy($image));  
	
		return $ret; 
    }
        
    function gd_newimage($width,$height) {
		return imagecreatetruecolor($width, $height); 
    }
    function gd_pixeltrans(&$image,$color) {
		return imagecolortransparent ($image, gd_hexgd($image,$color));    
    }
    
    function gd_line(&$image,$x,$y,$x2,$y2,$color="000000") {
		return imageline($image, $x,$y,$x2,$y2,gd_hexgd($image,$color));
    }
    function gd_rectangle(&$image,$x,$y,$w,$h,$color="000000") {
		$col = gd_hexgd($image,$color);
		
		imageline($image, $x,$y,$x,$y+$h,$col); //left
		imageline($image, $x,$y,$x+$w,$y,$col); //top
		imageline($image, $x+$w,$y,$x+$w,$y+$h,$col); //right
		imageline($image, $x,$y+$h,$x+$w,$y+$h,$col); //bottom
		
		return $image;
		
    }
    function gd_filledellipse(&$image,$x,$y,$w,$h,$color="ff0000") {
		$col = gd_hexgd($image,$color);
		imagefilledellipse ( $image, $x, $y, $w, $h, $col);
    }
    function gd_ellipse(&$image,$x,$y,$w,$h,$color="ff0000") {
		$col = gd_hexgd($image,$color);
		imageellipse ( $image, $x, $y, $w, $h, $col);
    }    
    function gd_loadimage($fname) { //ignore ext e.g. for xbm and xpm load jpg
		$arr = explode(".",$fname);
		$ext = strtolower($arr[count($arr)-1]);
		$func = 'imagecreatefrom';
		switch($ext) {
			case 'jpg' :
			case 'jpeg':
			case 'jpe' :  $func .= 'jpeg'; break;
			case 'png' :  $func .= 'png'; break;
			case 'gif' :  $func .= 'gif'; break;
			case 'xbm' :  $func .= 'xbm'; break;
			case 'wbmp':  $func .= 'wbmp'; break;
			
			/*case 'gif' :  $func .= 'jpeg'; break;
			case 'xbm' :  $func .= 'jpeg'; break;
			case 'xpm' :  $func .= 'jpeg'; break;
			case 'wbmp':  $func .= 'wbmp'; break;
			case 'bmp' :  $func .= 'jpeg'; break;
			case 'ico' :  $func .= 'png'; break;
			case 'cur' :  $func .= 'jpeg'; break;
			case 'ani' :  $func .= 'jpeg'; break;
			case 'txt' :  $func .= 'jpeg'; break;*/
			
		

		}
		if(!function_exists($func))
			return false;
		
		$res = @$func($fname);;
		if(!$res)
			$res = @imagecreatefromjpeg($fname);
		if(!$res) return false;
		
		return $res;
		
    }
    function gd_loadimage_orig($fname) {
		if(!file_exists($fname)) return false;
		
		$arr = explode(".",$fname);
		$ext = strtolower($arr[count($arr)-1]);

		if($ext=='jpe' or $ext == 'jpg') $ext = 'jpeg';
		
		$func = "imagecreatefrom$ext";			
				
		if(!function_exists($func)) 
			return false;

		//return $func($fname,$ext=='ico'?16:'',$ext=='ico'?32:100);
		return $func($fname);
		
    }    
	function gd_fit(&$image, $target) { 
	
		//takes the larger size of the width and height and applies the  
		//formula accordingly...this is so this script will work  
		//dynamically with any size image 
		
		$width = gd_width($image);
		$height = gd_height($image);
		
		if ($width > $height) { 
			$percentage = ($target / $width); 
		} else { 
			$percentage = ($target / $height); 
		} 
		
		//gets the new value and applies the percentage, then rounds the value 
		$width = round($width * $percentage); 
		$height = round($height * $percentage); 
		
		//returns the new sizes in html image tag format...this is so you 
		//can plug this function inside an image tag and just get the 
		
		return gd_resize($image,$width,$height);
		
	} 
	function gd_getfit(&$image, $target) { 
	
		//takes the larger size of the width and height and applies the  
		//formula accordingly...this is so this script will work  
		//dynamically with any size image 
		
		$width = gd_width($image);
		$height = gd_height($image);
		
		if ($width > $height) { 
			$percentage = ($target / $width); 
		} else { 
			$percentage = ($target / $height); 
		} 
		
		//gets the new value and applies the percentage, then rounds the value 
		$width = round($width * $percentage); 
		$height = round($height * $percentage); 
		
		//returns the new sizes in html image tag format...this is so you 
		//can plug this function inside an image tag and just get the 
		
		return Array('width'=>$width,'height'=>$height);
		
	} 	
    
    
    
    
    function write_jpeg(&$image,$fname,$quality=100) {
		if (function_exists("imagejpeg"))
			return @imagejpeg($image,$fname,$quality); 
		return false;
    }
    function write_png(&$image,$fname,$comp=9) {
		if (function_exists("imagejpng"))    
		if (function_exists("imagejpng"))    
			return @imagepng($image,$fname,$comp); 
		return false;			
    }    
    function write_gif(&$image,$fname) {
		if (function_exists("imagegif"))    
			return @imagegif($image,$fname); 
		return false;			
    }     
    

?>