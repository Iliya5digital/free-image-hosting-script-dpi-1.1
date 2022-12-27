<?
	/*
	+----------------------------------------------------------+
	|
	|	DPI 			(Lightweight ImageHosting Script)
	|	By			image-host-script.com
	|	Support		support@image-host-script.com
	|	Version		1.1b
	|
	|	Developer		Ali Imran Khan Shirani
	|
	|	Copyright		Clixint Technologies International
	|				www.clixint.com
	|
	+----------------------------------------------------------+
	*/	

	DEFINE('DSEP', chr(14).chr(10).chr(14));
	DEFINE('WSEP', chr(17).chr(10).chr(17));
	
	#galleries are just file names e.g. a_F,d_234,5_h
	DEFINE('USERS_', 		'username,email,password,ip,date,avatar,biodata,locked,next_contact_time,next_upload_time,reset_code,galleries,images'); 
	DEFINE('GALLERIES_', 	'username,title,description,tags,date,update,password,default_image,images');
	DEFINE('SETTINGS_', 	'allowuploading,seourls,maxnumimages,maxfilesize,filesizeguage,thumbxy,thumbuality,quality,imagesperpage,imagesperrow,emailfrom,namefrom,admin_user,contact_interval,upload_interval,default_module,theme,site_title,featured_images,blockedips');
	
	
	eval("DEFINE('URL_READING', ".intval(        ini_get('allow_url_fopen')).");");
	eval("DEFINE('CURL_READING',".intval(function_exists("curl_init"      )).");");
	eval("DEFINE('ZIP_READING', ".intval(function_exists("zip_open"       )).");");
	
	
	function load_temp_file($pattern,$filename) {
		$path = DATA_DIR."/".strtolower($pattern)."/$filename.".D_EXT;
		
		$data = load_file($path);
		if($data === FALSE or $data == "") return FALSE;
		#$data = gzuncompress($data);
		$pat = CONSTANT(strtoupper($pattern).'_');
		$pat = '$arr["'.str_replace(',','"], $arr["',$pat).'"]';
		
		$data = addslashes($data);
		$data = str_replace('$','\\$',$data);
		
		$ev  ="@list($pat) = explode(DSEP,\"$data\");";
		
		eval($ev);
			#die("EV error : $ev");
		return array_reverse($arr);
	}
	function mdate_temp_file($pattern,$filename) {
		$path = DATA_DIR."/".strtolower($pattern)."/$filename.".D_EXT;
		if(!file_exists($path)) { die( "$path does not exist"); return false; }
		return filemtime($path);
	}
	
	function get_temp_array($pattern) {
		$pat = CONSTANT(strtoupper($pattern).'_');
		$pat = 'Array("'.str_replace(',','"=>"","',$pat).'"=>"");';
		
		@eval("\$ret=$pat");
		return $ret;
	}
	function save_temp_file($pattern,$filename,$arr) {
		$path = DATA_DIR."/".strtolower($pattern)."/$filename.".D_EXT;
		$data = @implode(DSEP,$arr);
		#$data = gzcompress($data);
		$ret = write_file($path,$data);
		@chmod($path,0777);
		return $ret;
	}
	
	/************************ MODULE SPECIFIC *****************************/

	function load_settings() {
		$unc = load_temp_file('settings','settings');
		switch($unc['filesizeguage']) {
			case 'K': $unc['maxfilesize'] *= 1000; break;
			case 'M': $unc['maxfilesize'] *= 1000000; break;
		}
		return $unc;
	}	
	function settings_filesize_guage_fix($stg) {
		switch($stg['filesizeguage']) {
			case 'K': $stg['maxfilesize'] /= 1000; break;
			case 'M': $stg['maxfilesize'] /= 1000000; break;			
		}
		return $stg;
	}	
	function user($username) {
		$username = strtolower(trim($username));
		return load_temp_file('users',$username);
	}
	function user_exists($username) {
		$username = strtolower(trim($username));
		return file_exists(DATA_DIR.'/users/'.$username.'.'.D_EXT);
	}
	function gallery($file) {
		$file = trim($file);
		return load_temp_file('galleries',$file);
	}	
	function email_exists($email) {
		$email = strtolower(trim($email));
		
		$file = DATA_DIR.'/emails/'.strtoupper(substr($email,0,1)).'/'.md5($email).'.'.D_EXT;
		if(file_exists($file))	return true;
		return false;
	}	
	function user_by_email($email) {
		if(!email_exists($email)) return false;
		$email = strtolower(trim($email));
		
		$file = DATA_DIR.'/emails/'.strtoupper(substr($email,0,1)).'/'.md5($email).'.'.D_EXT;
		$data = load_file($file);
		@list($email,$username) = @explode(",",$data);
		
		return user($username);		
	}
	
	function add_email($email,$username) {
		$email = strtolower(trim($email));
		$file = DATA_DIR.'/emails/'.strtoupper(substr($email,0,1)).'/'.md5($email).'.'.D_EXT;
		return write_file($file,"$email,$username");
	}
	function add_images_to_user($arr,$gal) {
		global $logged_user,$settings;
		if(!$logged_user) return false;
		if($gal != "") {
			$logged_user['galleries'] = explode(",",$logged_user['galleries']);
			$found=false;
			foreach($logged_user['galleries'] as $c) {
				$temp = explode(":",$c);
				if(count($temp) != 2) continue;
				if(trim($temp[1]) == trim($gal)) {
					$found=true;
					break;
				}
			}
			if(!$found)  {
				#die("Not in array");
				$gal = "";
			} else {
				$gallery = gallery($gal);
				if(!$gallery){
					$gal="";
				}
				else if($gallery['username'] != $logged_user['username']) {
					$gal="";
				}
				else {
					#add to gallery here
					if($gallery['images'] == "")
						$gallery['images'] = implode(",",$arr);
					else {
						$gallery['images'] = explode(",",$gallery['images']);
						$gallery['images'] = array_merge($arr,$gallery['images']);
						$gallery['images'] = array_remove_empty(array_unique($gallery['images']));
						$gallery['images'] = implode(",",$gallery['images']);	
					}	
					$gallery['update'] = time();
					
					#not return
					save_temp_file('galleries',$gal,$gallery);
				}
			}
			$logged_user['galleries'] = implode(",",$logged_user['galleries']);
			
		}
		if($gal == "") {
			$logged_user['images'] = explode(",",$logged_user['images']);
			$logged_user['images'] = array_merge($arr,$logged_user['images']);
			$logged_user['images'] = array_remove_empty(array_unique($logged_user['images']));
			$logged_user['images'] = implode(",",$logged_user['images']);
		} 
		
		$logged_user['next_upload_time'] = time() + intval($settings['upload_interval']);
		return save_temp_file('users',strtolower($logged_user['username']),$logged_user);
	}
	function add_gallery_to_user($gal_name,$title) {
		global $logged_user;
		if(!$logged_user) return false;
		$title = $title =="" ? "Unknown" : $title;
		if($gal_name != "") {
			if($logged_user['galleries'] == "")
				$logged_user['galleries'] = "$title:$gal_name";
			else {
				$logged_user['galleries'] = explode(",",$logged_user['galleries']);
				$logged_user['galleries'][]="$title:$gal_name";
				$logged_user['galleries'] = array_unique($logged_user['galleries']);
				$logged_user['galleries'] = implode(",",$logged_user['galleries']);
			}
				
			return save_temp_file('users',strtolower($logged_user['username']),$logged_user);
		}	
		return false;
	}
	function remove_user_images($arr,$user_array) {
		$user_array['images'] = explode(",",$user_array['images']);
		$user_array['images'] = implode(",",array_remove_empty(array_unique(array_diff($user_array['images'],$arr))));
		return save_temp_file('users',strtolower($user_array['username']),$user_array);
	}
	function remove_gallery_images($galname,$gallery, $arr) {
		$gallery['images'] = explode(",",$gallery['images']);
		$gallery['images'] = implode(",",array_remove_empty(array_unique(array_diff($gallery['images'],$arr))));
		return save_temp_file('galleries',$galname,$gallery);
	}
	function add_user_images($arr) {
		global $logged_user;
		
		$logged_user['images'] = explode(",",$logged_user['images']);
		$logged_user['images'] = implode(",",array_remove_empty(array_unique(array_merge($logged_user['images'],$arr))));
		return save_temp_file('users',strtolower($logged_user['username']),$logged_user);		
	}
	function add_gallery_images($galname,$gallery, $arr) {
		$gallery['images'] = explode(",",$gallery['images']);
		$gallery['images'] = implode(",",array_remove_empty(array_unique(array_merge($gallery['images'],$arr))));
		return save_temp_file('galleries',$galname,$gallery);
	}		
	function delete_user_gallery($galname) {
		global $logged_user;
		$logged_user['galleries'] = explode(",",$logged_user['galleries']);
		$key = false;
		foreach($logged_user['galleries'] as $k => $gal) {
			$temp = explode(":",$gal);
			if(trim($temp[1]) == $galname) {
				$key = $k;
				break;
			}
		}
		if($key === FALSE) return FALSE;
		unset($logged_user['galleries'][$key]);
		$logged_user['galleries'] = implode(",",$logged_user['galleries']);	
		$gfile = DATA_DIR.'/galleries/'.$galname.'.'.D_EXT;
		
		unlink($gfile);
		return save_temp_file('users',strtolower($logged_user['username']),$logged_user);	
	}
	function get_featured_image() {
		global $settings,$root_path,$id;
		
		if($settings['featured_images'] == "") return false;
		
		if(!eregi(',',$settings['featured_images']))
			$id = $settings['featured_images'];
		else {
			$featured = explode(",",$settings['featured_images']);
			$id = $featured[rand(0,count($featured)-1)];
		}
		$featured_image_path = "$root_path/".IMAGE_DIRC."/featured/$id.jpg";
			
		return $featured_image_path;
	}	
	function galleries_combo($name,$sel="") {
		global $logged_user;
		if(!$logged_user) return false;
		$arr = Array('Select Gallery to save to:');
		$logged_user['galleries'] = explode(",",$logged_user['galleries']);
		foreach($logged_user['galleries'] as $gal) {
			$gal = trim($gal);
			if($gal == "" or !eregi(':',$gal)) continue;
			$gal = explode(":",$gal);
			$arr []= "$gal[0]:$gal[1]";
		}
		return create_combo($name,implode(";",$arr),$sel,''," style='width:200px;'");
	}	
?>