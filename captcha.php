<?
	/*
	+----------------------------------------------------------+
	|
	|	DPI 			(Lightweight ImageHosting Script)
	|	By			image-host-script.com
	|	Support		support@image-host-script.com
	|	Version		1.1 Final
	|
	|	Developer		Ali Imran Khan Shirani
	|
	|	Copyright		Clixint Technologies International
	|				www.clixint.com
	|
	+----------------------------------------------------------+
	*/	

	REQUIRE_ONCE( 'dpi_init.php' );
	REQUIRE_ONCE( './includes/dpi_ext.php' );


	$variant = true;
	$text = substr(strtoupper(md5(md5(time().crypt('k')))),0,$variant ? rand(4,6) : 6);
	#setcookie('usercap',md5($ccode),time() + 3600,"/",$cdomain);
	$_SESSION['usercap'] = md5($text);
		
	
	$padding = 5;
	$fsize = 15;
	$ttf  ="./theme/fonts/tahoma.ttf";
	$size = imagettfbbox($fsize, 0, $ttf, $text);
	
	$xsize = abs($size[0]) + abs($size[2])+($padding*2) + ($fsize+$padding);
	$ysize = abs($size[5]) + abs($size[1])+($padding*2);
	
	$image = imagecreate($xsize, $ysize);
	
	$bgcolor = gd_hexgd($image,"EEEEEE");
	$fgcolor = gd_hexgd($image,"333333");
	$blcolor = gd_hexgd($image,"999999");
	
	for($i=0; $i<strlen($text); $i++) {
		imagettftext($image, $fsize, rand(-30,30), $padding+($i*$fsize), $fsize+$padding, $fgcolor, $ttf, $text{$i});
	}

	imagesetthickness ($image,2);

	imagearc ($image, $xsize/2, ($ysize/2)+$fsize, $xsize, ($ysize/2)+$fsize, -180, -90, $blcolor);
	imagearc ($image, $xsize, ($ysize/2)+$fsize, $xsize, ($ysize/2)+$fsize, -180, -90, $blcolor);

	
	#gd_line($image,0,13,100,13,"FF00FF");
	header( 'Cache-Control: no-store, no-cache, must-revalidate' );
	header('Content-Type: image/pjpeg'); 
	imagejpeg($image,'',80);	
	
?>