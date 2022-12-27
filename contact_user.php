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
	
	
	
	if(!$logged_user) 
		$center = message("You must be a registed and logged users in order to contact a registered user!");
	else {
	
		$uid = _html(@$_GET['id']);
		$USR = user($uid);
		
		
		if(!$USR)
			$center = message("Invalid profile link followed!");
		else {
			$USR = html_arr($USR);
			$title = "Contact $USR[username]";
			
			if(intval($logged_user['next_contact_time']) > time())
				$center = message("Extensive use detected! Administrator has set a time interval of ".($settings['contact_interval']/60)." minutes. Please try again after ".sprintf("%.2f",$logged_user['next_contact_time']-time())." seconds.");
			else {
				if(act('process')) {
					#$settings['contact_interval']
					
					check_magic_quotes();
					$error = "";
					if(strlen(trim(@$_POST['message'])) < 10)
						$error = "Too short message, it must be minimum 10 characters.";
					else 
					if(md5(strtoupper(@$_POST['captcha'])) != @$_SESSION["usercap"]) 
						$error = "Inalid security code entered";
				
					if($error != "") {
						$_POST = html_arr($_POST);
						$center = eval_template("contact_user");
					} else {
						#dispatch message 
						
						$subject = "Message by - $logged_user[username]";
						$_POST['message'] = substr(trim($_POST['message']),0, 1000);
						$body = "
						
NOTE: $root_path does not have control over quality / language / content used
as outgoing message by any user. You may contact site Administrator to report
abuse of service at $settings[emailfrom].
						
Dear $USR[username],

A registered user $logged_user[username] has entered the following message:

$_POST[message]
---

User's profile
$root_path/profile.php?id=$logged_user[username]							
----------------------------
DPI $root_path
			";
			
						@mail(
							$USR['email'], 
							$subject, 
							$body,
							"From: \"$settings[namefrom]\" <$settings[emailfrom]>"
						);	
						
						$logged_user['next_contact_time'] = time() + $settings['contact_interval'];
						save_temp_file('users',strtolower($logged_user['username']),$logged_user);
						
						redirect("$root_path/misc.php?e=".base64_encode("Your message has successfuly been delivered to usr $USR[username]"),0);
						die();
					}
				
				
				} else {
			
					$center = eval_template("contact_user");
				}
				
			}
			
			
		}
	}
	echo 
		eval_template('header').
		eval_template('body').
		eval_template('footer');
		
		
	
?>