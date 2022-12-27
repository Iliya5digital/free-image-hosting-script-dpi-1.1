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
	
	
	
	$g_list = "";
	
	
	$uid = _html(@$_GET['id']);
	$USR = user($uid);
	
	$title = "Invalid Profile";
	
	
	if(!$USR)
		$center = message("Invalid profile link followed!");
	else {
		$title = "$uid's profile";
		
		#GALLERIES DISLAY
		$USR = html_arr($USR);
		
		$USR['date'] = date("F d, Y",$USR['date'] );
		
		$gals = explode(",", $USR['galleries']);
		
		$galleries= "";
		
		if(_count($gals) == 0)
			$galleries = message("user has bot yet posted any galleries!");
		else {
			$gals = array_reverse($gals);
			foreach($gals as $gid) {
			
				@list($gtitle,$gid) = explode(":",$gid);
				$gal = gallery($gid);
				if(!$gal) continue;
				
				$gal = html_arr($gal);
				
						
				if($settings['seourls'] == 'N')
					$ipath = "$root_path/gallery.php?id=$gid";
				else
					$ipath = "$root_path/gallery-".valid_galery_name_characters($gal['title'])."-$gid.html";					
				
				if($gal['password'] != "") {
					$tpath = "$root_path/theme/$settings[theme]/images/gal_locked.gif";
					
				} else {
					if($gal['default_image'] != "") {
						$tpath = 
							$settings['seourls'] == 'N' ?
							"$root_path/thumb.php?id=$gal[default_image]" :
							"$root_path/thumb-$gal[default_image].jpg" ;						
					} else
						$tpath = "$root_path/theme/$settings[theme]/images/gallery_default.gif";
				}
				
				$gal['date'] = date("F d, Y", intval($gal['date']));
				$gal['update'] = date("F d, Y",intval($gal['update']));
				
				$galleries .= eval_template("profile_gallery_thumb");
				
			}			
		}
		
		$avatar_url = "$root_path/theme/$settings[theme]/images/avatar_def.gif";
		if($USR['avatar'] != "") {
			@list($uniq,$idate) = @explode("_",$USR['avatar']);
			$decdate = hexdec($idate);
			$avatar_url = "$root_path".IMAGE_DIRC.'/thumbs/'.date("Y/F/d",$decdate)."/$USR[avatar].jpg";
			
		}
		
		$USR['biodata'] = nl2br($USR['biodata']); 
		
		$center = eval_template("profile");
	}

	echo 
		eval_template('header').
		eval_template('body').
		eval_template('footer');
		
		
	
?>