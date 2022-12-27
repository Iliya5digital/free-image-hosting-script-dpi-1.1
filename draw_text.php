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
	
	
	if($settings['allowuploading'] == '0') 
		die(flash_print("msg","Sorry, te image creation and uploading has been disabled by administrator."));
	if($logged_user && intval(@$logged_user['next_upload_time']) > time() && $settings['admin_user'] != @$logged_user['username'])
			die(flash_print("msg","Extensive use detected! Administrator has set a time interval of ".($settings['upload_interval']/60)." minutes. Please try again after ".sprintf("%.2f",$logged_user['next_upload_time']-time())." seconds."));
	if(!$logged_user && (intval(@$_SESSION['next_upload_time']) > time()  || intval(@$_COOKIE['next_upload_time']) > time()) )
			die(flash_print("msg","Extensive use detected! Administrator has set a time interval of ".($settings['upload_interval']/60)." minutes. Please try again after ".sprintf("%.2f",(intval(@$_SESSION['next_upload_time']) > intval(@$_COOKIE['next_upload_time']) ? @$_SESSION['next_upload_time'] : @$_COOKIE['next_upload_time'])-time())." seconds."));
	
	
	$tfolder = get_todays_folder($th,$im);
	if(!$tfolder) 
	die(flash_print("msg","Critical ERROR 1: Report to administrator please"));
	$currtime = time();
	
	
	flash_print("msg","");
	
	REQUIRE_ONCE( './includes/dpi_ext.php' );
	

	$_SESSION['last_draw'] = $_POST['datastring'];

	#write_file("draw.txt",$_POST['datastring']);
	
	$arr = explode("<W>",$_POST['datastring']);
	
	if(_count($arr) > 50) 
		die(flash_print("msg","Sorry, objects must be less than 50. Please delete some objects andtry again."));
		
	$arr[0] = $arr[0] > 1000 ? 1000 : $arr[0];
	$arr[0] = $arr[0] < 50 ? 50 : $arr[0];
	$arr[1] = $arr[1] > 1000 ? 1000 : $arr[1];
	$arr[1] = $arr[1] < 50 ? 50 : $arr[1];
	
	$image = gd_newimage($arr[0],$arr[1]);
	gd_bar($image,0,0,$arr[0],$arr[1],"FFFFFF");
	unset($arr[0],$arr[1]);
	foreach($arr as $k => $v) {
		$v = explode(",",$v);
		switch($v[0]) {
			case 'line':
				gd_line($image,$v[1],$v[2],$v[3],$v[4],"000000");
				break;
			case 'rect':
				gd_bar($image,$v[1],$v[2],$v[3],$v[4],"ff0000");
				gd_rectangle($image,$v[1],$v[2],$v[3],$v[4],"000000");
				break;
			case 'ellipse':
				gd_filledellipse($image,$v[1],$v[2],$v[3],$v[4],"00ff00");
				gd_ellipse($image,$v[1],$v[2],$v[3],$v[4],"000000");
				
		}
	}
	
	$id = get_unique_filename($currtime);
	#create thumb
	$thumb = gd_fit($image,$settings['thumbxy']);
	imagejpeg($thumb,"$th/$id.jpg",$settings['thumbuality']);
	imagedestroy($thumb);
	#then save actual jpeg
	imagejpeg($image,"$im/$id.jpg",$settings['quality']);
	imagedestroy($image);	
	
	$iptcstr = $_POST['datastring'];
	$iptc = new iptc("$im/$id.jpg");
	$iptc->set( DPI_SOURCE ,gzcompress($iptcstr));
	if($logged_user)
		$iptc->set( DPI_AUTHOR ,$logged_user['username']);

	$iptc->write();			
	
	$uniques = array($id);
					
	if($logged_user)
		add_images_to_user($uniques,0);
	else {
		$sess_name = 's_'.md5(_ip());
		if(isset($_SESSION[$sess_name])) {
			$temp = explode(",",$_SESSION[$sess_name]);
			$temp = array_merge($uniques,$temp);
			$_SESSION[$sess_name] = implode(",",$temp);
			$uniques = $temp;
		} else
			$_SESSION[$sess_name] = implode(",",$uniques);
			
		$_SESSION['next_upload_time'] = time() + intval($settings['upload_interval']);
		setcookie('next_upload_time',time() + intval($settings['upload_interval']),time()+3600,"/",$cdomain);
		
	}
	
	append_new("$th/public.txt",$uniques);
	
	$errors = Array();
	$is_gallery=false;
	$msg="";

	$msg = !empty($errors) ? "&e=".base64_encode(implode("\r",$errors)) : (empty($uniques) ? "e=".base64_encode("No filed uploaded!") : CX_NONEZ);
	$REDIRECT_PATH = "$root_path/".($is_gallery ? "mygalleries.php?id=$is_gallery" : "misc.php?".(!empty($uniques)?"showseries=".urlencode(base64_encode(implode(",",$uniques))): CX_NONES )  ) . '&'.$msg;
			
	
	flash_print("redirect_url",$REDIRECT_PATH);
	
	
	function flash_text($val) {
		$val = str_replace("/","%2F",str_replace("?","%3F",str_replace("=","%3D",str_replace(":","%3A",str_replace("&","%26",str_replace("%","%25",$val))))));
		return $val;
	}	
	function flash_print($var,$val) {
		echo "&$var=".flash_text($val)."&";
	}	

?>