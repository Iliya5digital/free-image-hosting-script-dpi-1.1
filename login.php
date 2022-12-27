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
	
	DEFINE('NOGZ',	TRUE);

	include_once ('dpi_init.php');
	
	$title = "User Log In";
	
	$error = "";
	
	if(act('clear')) {
		session_destroy();
		redirect($_SERVER['HTTP_REFERER'],0);
		die();
	}
	if(act('out')) {
		#user wants to log out
		if(!@setcookie('user',"",time(),"/",$cdomain))
			#failed to save cookie in user's browser
			$error = "Your browser is not supporting cookies, please turn them ON in order to log out, or manually clean browser cookies.";
		else {
			echo "Logged out successfully, redirecting to homepage!";
			redirect("$root_path/index.php",1);
			die();
		}		
	}
	
	if($logged_user) {
		redirect("$root_path/index.php",1);
		die();
	}
	
	if(act('process')) {
		#user entered login info, process it
		check_magic_quotes();
		
		
		if(
			!isset($_POST['username']) or
			!isset($_POST['password'])
		) $error = "Invalid HTTP request";
		else
		if(!($USR = user($_POST['username'])) )
			$error = "Username not found!";
		else
		if($_POST['password'] == '')
			$error = "Empty password supplied!";	
		else 
		if($USR['password'] != md5($_POST['password'])) 
			$error = "Invalid password supplied";
				

		if($error == "") {
			#all supplied information was correct, login here, save cookie
			if($USR['locked'] == 'Y') 
				$error = message("Sorry cannot login! Your account has been suspended by administrator!");
			else {	
				if(!@setcookie('user',"$USR[username],".md5($USR['password']),time()+(3600*24),"/",$cdomain))
					#failed to save cookie in user's browser
					$error = "Your browser is not supporting cookies, please turn them ON in order to login";
				else {
				
					if(isset($_POST['preserve']) && $V_TIMAGES) {
						#move untracked to account
						
						$sname = 's_'.md5(_ip());
						session_destroy();					
						$USR['images'] = implode(",", 
							array_merge(explode(",",_html(@$_SESSION[$sname])), explode(",",$USR['images'])) 
						); 
						
						save_temp_file('users',strtolower($USR['username']),$USR);
					}
				
				
					$ref = isset($_POST['ref']) ? $_POST['ref'] : "$root_path/index.php";
					echo "Logged in successfully, redirecting to homepage!";
					redirect("$root_path/index.php",0);
					die();
				}
			}
		}
		
		if($error != "") {
			$ref = isset($_POST['ref']) ? $_POST['ref'] : "$root_path/index.php";
			$_POST = html_arr($_POST);
			$login_track_images = $V_TIMAGES ? eval_template("login_extra") : "";
			$center = eval_template('login');		
		}
		
	} else {
		#no querystring so display login template
		$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "$root_path/index.php";
		
		$login_track_images = $V_TIMAGES ? eval_template("login_extra") : "";
		
		
		$center = eval_template('login');
	}
	


	echo 
		eval_template("header"),
		eval_template("body"),
		eval_template("footer");




?>