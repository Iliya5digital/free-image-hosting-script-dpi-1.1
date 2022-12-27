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
	session_start();
	list($usec, $sec) = explode(" ", microtime()); 
     $START_TIME = ((float)$usec + (float)$sec); $WIPED_TIME = 0;
	
	$root_path ="{ROOT_PATH}";
	$cdomain	 ="{C_DOMAIN}";

	if(!DEFINED('NOGZ') && eregi('gzip',$_SERVER['HTTP_ACCEPT_ENCODING'])) @ob_start("ob_gzhandler");
	
	REQUIRE_ONCE( './includes/dpi_functions.php'	);
	REQUIRE_ONCE( './includes/dpi_temp.php'		);
	REQUIRE_ONCE( './includes/dpi_specials.php'	);
	REQUIRE_ONCE( './includes/dpi_iptc.php'		);
	REQUIRE_ONCE( './includes/dpi_custom.php'	);
	
	
	$settings	= load_settings();
	DEFINE('TEMP_DIR',  "./theme/$settings[theme]/templates");	
		
		
	#Load the Global Settings
	$meta_tags = eval_template('header_meta_tags');
	$header_right = eval_template('header_right');
	$myurl = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
	
	$center 		= '';		#Initialize center content
	$title		= '';
	$logged_user	= FALSE;
	
	if(isset($_COOKIE['user'])) {
		@list($id,$pass) = @explode(',',$_COOKIE['user']);
		$id = _html($id);
		$pass = _html($pass);
		$USR = user($id);
		
		if($USR) {
			if(md5($USR['password']) == $pass) {
				$logged_user = html_arr($USR);
				$admincp_link = strtolower($settings['admin_user']) == strtolower($logged_user['username']) ? eval_template('user_admin_link') : '';
				
				if($logged_user['locked'] == 'Y') {
					setcookie('user','',time(),'/',$cdomain);
					echo "Automatically logging out, your account has been suspended by administrator.<br>";
					redirect("$root_path/index.php",3);
					die();
				}
				
			}
		}
	}
	
	$header_links = eval_template($logged_user ? 'user_links' :'visitor_links');
	$V_TIMAGES=false;
	if(!$logged_user) {
		if(isset($_SESSION['s_'.md5(_ip())])) {
			$total_images = substr_count($_SESSION['s_'.md5(_ip())],',');
			$total_images++;
			$series = urlencode(base64_encode($_SESSION['s_'.md5(_ip())]));
			$header_links .= eval_template('visitor_totals');
			$V_TIMAGES=true;
		}
	}
	
	$iarchive_p1 = date("Y_F_d",filemtime(DATA_DIR."/LID"));
	$css = eval_template("css");
	
?>