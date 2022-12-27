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

	REQUIRE_ONCE( 'dpi_init.php' );
	
	/************* CHECK CACHED PAGE **************************/
	compare_cache(@filemtime(TEMP_DIR."/".$arr[0].".tpl"));
	/************* CHECK CACHED PAGE **************************/
	
	
	if(empty($_GET))
		$center = message("Invalid content request!");
	else {
		$arr = array_keys($_GET);
		$text = nl2br(eval_template($arr[0]));
		
		$text = str_replace('[*]','<li>',$text);
		
		$text = preg_replace("`\b(https?|ftp|file)://[-A-Za-z0-9+&@#/%?=~_|!:,.;]*[-A-Za-z0-9+&@#/%=~_|]\b`", 
					
					'<a href="\0" target="_blank" rel="nofollow" title="External Link, will open in new window">\0</a>', 
					$text
		); 
		
		$center = "<div class=\"quote\">$text</div>";
	}



	echo 
		eval_template("header") .
		eval_template("body") .
		eval_template("footer")
	;

?>