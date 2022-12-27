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

	function settings_special(&$unc) {
		$unc['filesizeguage'] = chr($unc['filesizeguage']);
		switch($unc['filesizeguage']) {
			case 'K': $unc['maxfilesize'] *= 1000; break;
			case 'M': $unc['maxfilesize'] *= 1000000; break;
		}
	}


?>