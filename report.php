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
	REQUIRE_ONCE('dpi_init.php');
	
	$title .= " - Report abuse";
	
	if(!$logged_user)
		die("Sorry: This feature is for registered users only!");
	
	if(intval(@$_SESSION["lastreport"]) > time()-60)
		die("Sorry: You recently have reported an image, you must report one image within duration of 1 minute.");
	
	if(!act('id')) 
	{
		die("An Invalid or outdated link followed!");	
	} 
	else 
	{
		
		list($id,$xdate) = @explode("_",_html(@$_GET['id']));
		eval("\$idate = 0x$xdate;");
		
		$lc_path = IMAGE_DIR.'/images/'.date("Y/F/d",$idate)."/{$id}_{$xdate}.jpg";
		if(!file_exists($lc_path)) 
			die("An Invalid or outdated link followed!");	
			
		if(!act('process')) {
			$center = eval_template("report_image");
		} else {
			#process the form here
			#$image_path = $root_path.IMAGE_DIRC.'/images/'.date("Y/F/d",$idate)."/{$id}_{$xdate}.jpg";
			$error='';
			if(md5(strtoupper($_POST['captcha'])) != @$_SESSION["usercap"]) {
				$error = "Inalid security code entered";			
			}
			$_SESSION["usercap"] = '';
			if($error != "")
				$center = eval_template("report_image");
			else {
				
				$USR = user($settings['admin_user']);
				
				
				#send message here
				$message = _html(substr(@$_POST['message'],0,100));
			@mail($USR['email'], "Reported Abuse {$id}_{$xdate}", 
			"
Hello administrator,

User '$logged_user[username]' has reported following image to be against your terms.
$root_path/share.php?id={$id}_{$xdate}
-------------
$message
-------------

User's Profile
$root_path/profile.php?id=$logged_user[username]


----------------------------
Automated Message By
DPI $root_path
			",
			"From: \"$settings[namefrom]\" <$settings[emailfrom]>");				
				$_SESSION["lastreport"] = time();
			
				echo "Abuse of Terms successfully reported to administrtor!<br><br>";
				
			
				redirect("$root_path/share.php?id={$id}_{$xdate}");
				die();
			}
		}
		
	}	
	
	echo 
		eval_template("header") .
		eval_template("body") .
		eval_template("footer")
	;
	
	
?>