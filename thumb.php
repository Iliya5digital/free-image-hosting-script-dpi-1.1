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
	DEFINE('NOGZ', TRUE);

	REQUIRE_ONCE('dpi_init.php');
	
	
	if(!act('id')) {
		header("Location: $root_path/theme/$settings[theme]/images/404.jpg");	
	} 
	else {
		
		list($id,$xdate) = @explode("_",_html(@$_GET['id']));
		$idate = @hexdec($xdate);
		
		$image_path = IMAGE_DIR.'/thumbs/'.@date("Y/F/d",$idate)."/{$id}_{$xdate}.jpg";
		if(!file_exists($image_path)) {
			header("Location: $root_path/theme/$settings[theme]/images/404.jpg");
			die();
		}
		$last_modified = gmdate('D, d M Y H:i:s',filemtime($image_path)).' GMT';
		
		/************* CHECK CACHED IMAGE **************************/
		compare_cache($last_modified);
		/************* CHECK CACHED IMAGE **************************/
		
		#SEND ONCE
		$content_length = filesize($image_path);
		header('Cache-Control: max-age=86400, must-revalidate');
		header('Content-Length: '.$content_length);
		header('Last-Modified: '.$last_modified);
		header("Content-Type: image/jpeg");

		readfile($image_path);

		die();
	}	
	
	
?>