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
	
	REQUIRE_ONCE ('dpi_init.php');
	
	$title = "Register new account";
	
	if($logged_user) { redirect("$root_path/index.php",0); die(); }
	
	$error = "";
	
	
	if(act('process')) { 
	
		check_magic_quotes();
		
		if(strlen($_POST['username']) < 3)
			$error = "Too short username supplied. Minimum 3 characters are required.";
		else
		if(valid_characters($_POST['username']) != $_POST['username']) 
			$error = "Invalid characters found in username. Use any amongst A-Z, 0-9, -, and _";
		else
		if(strlen($_POST['username']) > 15)
			$error = "Too large username. Maximum 15 characters";
		else		
		if(user_exists($_POST['username'])) 
			$error = "Username not available, pelase try another";
		else
		if(!valid_email($_POST['email'])) 	
			$error = "Invalid email address supplied. Without supplying a valid email address you will not recieve password to login.";
		else 
		if(email_exists($_POST['email'])) 	
			$error = "Email has already been registered with an account, please try another.";
		else
		if(md5(strtoupper($_POST['captcha'])) != @$_SESSION["usercap"]) 
			$error = "Inalid security code entered";
			
		if($error != "") {
			$_POST = html_arr($_POST);
			$center = eval_template("register");
		} else {
			#info is compelte
			
			#captcah revalidation
			#setcookie('usercap','',time(),"/",$cdomain);
			
			$newpass = substr( strtoupper(md5(_ip().time().$_POST['captcha'].crypt('k'))) ,0,10);
			
			$USR = get_temp_array('users');
			$USR['username'] 	= substr($_POST['username'],0,15);
			$USR['email'] 		= $_POST['email'];
			$USR['ip'] 		= _ip();
			$USR['date'] 		= time();
			$USR['locked'] 	= 'N';
			$USR['biodata'] 	= substr($_POST['biodata'],0,1000);
			$USR['password'] 	= md5($newpass);
			
			$sname = 's_'.md5(_ip());
			if(isset($_SESSION[$sname])) {
				#move session images to user account
				$USR['images'] = _html($_SESSION[$sname]);
				session_destroy();
			}
			save_temp_file('users',strtolower($_POST['username']),$USR);
			add_email($_POST['email'],$_POST['username']);
			
			if(trim($settings['admin_user']) == '') {
				$stg = settings_filesize_guage_fix($settings);
				$stg['admin_user'] = $USR['username'];
				save_temp_file('settings','settings',$stg);	
			}
			
			
			@mail($_POST['email'], "Account Password", 
			"
Hello $_POST[username],

Probably you, or someone else has registered an account at 
$root_path
using your email address.

Please use following information to login
$root_path/login.php
Username: $_POST[username]
Password: $newpass

----------------------------
Automated Message By
DPI $root_path
			",
			"From: \"$settings[namefrom]\" <$settings[emailfrom]>");
			
			
			
			
			redirect("$root_path/misc.php?e=".base64_encode("CONGRATULATIONS: Account successfully created. A password has been issued to your supplied email address which may arrive momentarily. Please view your email inbox, especially check your junk/spam folders if you cannot find the message in inbox folder.^$root_path/login.php"),1);
			die();
			
		}
		
	
	} else {
		$center = eval_template("register");
	}	


	echo 
		eval_template("header"),
		eval_template("body"),
		eval_template("footer");


	@CLOSE_CONNECTION();

?>