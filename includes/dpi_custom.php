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
	define('DPI_TITLE',IPTC_CAPTION);	
	define('DPI_SOURCE',IPTC_SOURCE);	
	define('DPI_AUTHOR',IPTC_CREDIT);	
	define('DPI_GALLERY',IPTC_CATEGORY);
	define('DPI_RATING',IPTC_OBJECT_CYCLE);
	define('DPI_GIF',IPTC_OBJECT_PREVIEW_DATA);//IPTC_ORIGINAL_TRANSMISSION_REFERENCE);
	
	
	function set_image_gallery($filename,$gallery) {
		$i = new iptc($filename);
		$i->set(DPI_GALLERY,$gallery);
		$i->write();
	}

?>