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
	
	$title = "Forgot my password";
	
	if($logged_user) 
		$center = message("You are already logged unser usrename "._html($logged_user['username']));
	else {
	
	
	
		if(act('process')) {
			#process here
			$error = "";
			switch(@$_POST['option']) {
				case 'u': $USR = user(_html(@$_POST['username'])); break;
				case 'e': $USR = user_by_email(_html(@$_POST['email'])); break;
			}
			
			if(!$USR)
				$error = "User account not found in database1";
			else
			if(md5(strtoupper(@$_POST['captcha'])) != @$_SESSION["usercap"]) 
				$error = "Inalid security code entered";
			
			if($error != "") {
				$_POST = html_arr($_POST);
				$center = eval_template("forgot_password");
			} else {
				#allow reset
				$code = substr(strtoupper(md5(time().crypt('k')._ip())) , 0, 10)  ;
				$USR['reset_code'] = $code;
				
				save_temp_file('users',strtolower($USR['username']),$USR);
				
				$link = "$root_path/misc.php?r=".urlencode(base64_encode(md5($code) .','.$USR['username']));
				
				@mail(
					$USR['email'],
					"Password Reset Request",
					"
Dear $USR[username],

Probably you (or someone else who knows your email addres), have requested
to reset your password.

Your password is not yet changed, you may change your password by visiting following link:
$link

OR, you may simply ignore this message.

----------------------------
DPI $root_path

","From: \"$settings[namefrom]\" <$settings[emailfrom]>");	
			
				redirect("$root_path/misc.php?e=".base64_encode("An email has just been dispatched to your email address, containing the link to reset the password. Said message may arrive momentarily."),0);
				die();
			}
			
			
		} else {
			$center = eval_template("forgot_password");
		}
	}
	echo 
		eval_template('header').
		eval_template('body').
		eval_template('footer');
		



		
	
?>