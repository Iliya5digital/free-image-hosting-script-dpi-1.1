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
	

	REQUIRE_ONCE('dpi_init.php');
	
	$title = "My Images & Galleries";
	
	
	if(!$logged_user) {
		redirect("$root_path/archive.php?id=0",0);
		die();
	}

	if(act('e')) {
		@list($msg,$url) = explode("^",base64_decode($_GET['e']));
		
		$center = message("".nl2br($msg) . ($url!='' ?"<br><br><br><a href=\"$url\">Click here to continue.</a>":''));
	} else
	if(act('update')) {
		check_magic_quotes();
		
		$error="";
		#if(strlen($_POST['password']) < 3)
		#	$error = "Too Small new password, use minimun 3 characters.";
		#else	
		if(strlen($_POST['password']) > 15)
			$error = "Too large new password, use maximum 15 characters.";
		else 
		if(strlen($_POST['biodata']) > 1000)
			$error = "Biodata must be maximum 1000 characters (1kb), you have ".strlen($_POST['biodata'])." characters.";
		else
			if(md5(strtoupper($_POST['captcha'])) != @$_SESSION["usercap"]) 
				$error = "Inalid security code entered";		
		
		if($error != "") {
			$center .= eval_template("settings");
		} else {
			#update settings
			if(strlen($_POST['password']) > 0)
				$logged_user['password'] = md5(trim($_POST['password']));
			
			$logged_user['biodata'] = substr($_POST['biodata'],0,1000);
			
			save_temp_file('users',strtolower($logged_user['username']),$logged_user);
			redirect("$root_path/index.php",1);
			die();
		}
	} else {
		$center .= eval_template("settings");
	}
	
	
	echo 
		eval_template('header').
		eval_template('body').
		eval_template('footer');
		
		

?>