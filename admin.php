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
	
	if($settings['admin_user'] != @$logged_user['username']) die("Authorization denied!");
	
	$center='';
	
	if(empty($_GET)) {
		$center = eval_template("admin_main");
	} else
	if(act('e')) {
		@list($msg,$url) = explode("^",base64_decode($_GET['e']));
		
		$topamsg = message("".nl2br($msg) . ($url!='' ?"<br><br><br><a href=\"$url\">Click here to continue.</a>":''));
	} else
	if(act('seo')) {
		
		$seourls = create_combo('seourls','Yes:Y;No:N',$settings['seourls']);

		$center .= eval_template('admin_settings_seo');
	} else	
	if(act('modules')) {
		@list($ms,$defult_module) = explode(":",trim(template('admin_settings_modules_list')));
		$ms = explodE(";",$ms);
		$modules = Array();
		$modules_rows = "";
		$x=0;
		foreach($ms as $v) {
			$temp = explode(",",trim($v));
			$modules [$temp[0]] = Array(
				'title'		=>	_html($temp[1]),
				'active'		=>	intval($temp[2]),
				'multiply'	=>	intval($temp[3])
			);
			$active = create_combo("active$x","Active:1;Inactive:0",$temp[2]);
			$multiple = create_combo("multiple$x","Yes:1;No:0",$temp[3]);
			$modules_rows .= "
				<tr>
					<td>
						<input type='radio' value='$temp[0]' name='selected'".($settings['default_module']==$temp[0] ? " checked":"").">
					</td>
					<td>
						<input type='hidden' name='name$x' value='$temp[0]'>
						<img src='$root_path/theme/$settings[theme]/images/module_$temp[0].gif' valign='middle'>
						&nbsp;
						&nbsp;
						<input type='text' name='title$x' value=\""._html($temp[1])."\">
					</td>
					<td>$active</td>
					<td>$multiple</td>
				</tr>
			";
			$x++;
		}
		$total_modules = _count($modules);
		$center .= eval_template('admin_settings_modules');
	} else
	if(act('updatemodules')) {
		check_magic_quotes();
		$text = Array();
		for($i=0; $i<$_POST['num']; $i++) {
			$text []= 
					$_POST["name$i"].",".
					$_POST["title$i"].",".
					$_POST["active$i"].",".
					$_POST["multiple$i"];
		}
		
		$text = implode(";\r\n",$text);
		write_file("./theme/$settings[theme]/templates/admin_settings_modules_list.tpl",$text);
		
		$stg = $settings;
		switch($stg['filesizeguage']) {
			case 'K': $stg['maxfilesize'] /= 1000; break;
			case 'M': $stg['maxfilesize'] /= 1000000; break;
		}
		
		$stg['default_module'] = $_POST['selected'];
		save_temp_file('settings','settings',$stg);		
		
		redirect("$root_path/admin.php?e=".base64_encode("Changes successfully saved.."),0);
		die();		
	} else
	if(act('settings')) {
		

		$thumbuality = array();	
		$quality = array();	
		for($i=12; $i<=100; $i++) {
			$thumbuality[]= "$i:$i";
			$quality[]= "$i:$i";
		}
			
		$thumbuality = create_combo('thumbuality',implode(";",$thumbuality), $settings['thumbuality']);
		$quality = create_combo('quality',implode(";",$quality), $settings['quality']);	
		
		$center .= eval_template('admin_settings');
	} else
	if(act('flood')) {
	
		$filesizeguage = create_combo('filesizeguage','KB) Kilo Bytes:K;MB) Mega Bytes:M',$settings['filesizeguage']);
		
		switch($settings['filesizeguage']) {
			case 'K': $settings['maxfilesize'] /= 1000; break;
			case 'M': $settings['maxfilesize'] /= 1000000; break;
		}			
		$allowuploading = create_combo('allowuploading','ON:1;OFF:0',$settings['allowuploading'],"javascript:hide('currof')");
		$center .= eval_template('admin_settings_flood');
	} else
	if(act('ipban')) {
		$center .= eval_template('admin_settings_ip');
	} else
	if(act('updatesettings')) {
		check_magic_quotes();
		
		$stg = $settings;
		foreach($_POST as $k => $v) 
			$stg[$k] = trim($v);
		if(!pct('maxfilesize')) {
			switch($stg['filesizeguage']) {
				case 'K': $stg['maxfilesize'] /= 1000; break;
				case 'M': $stg['maxfilesize'] /= 1000000; break;
			}
		}

		$extra = "";
		if(pct('seourls')) {
			$mark1 = "# BEGIN DPIOptions";
			$mark2 = "# END DPIOptions";
			if($_POST['seourls'] == "Y") {
				#need to rewrite .htaccess file
				$data = load_file("./.htaccess");
				$already = "";
				if($data !== FALSE) {
					#already has data
					$pos1 = strpos($data,$mark1);
					if($pos1 !== FALSE) {
						$pos2 = strpos($data,$mark2,$pos1+strlen($mark1));
						if($pos2 !== FALSE) {
							$already = substr($data,$pos1,($pos2+strlen($mark2)) - $pos1);
							
							$htdata = eval_template("root_htaccess");
							$new = str_replace($already,$htdata,$data);
						} else {
							$data = str_replace($mark1,"",$data);
							$new = $data ."\r\n". eval_template("root_htaccess");
						}
					} else $new = $data ."\r\n". eval_template("root_htaccess");
						
				} else 
					$new = eval_template("root_htaccess");
				
				@chmod("./.htaccess",0777);
				
				if(!write_file("./.htaccess",$new)) {
					$stg['seourls'] = 'N';
					$extra = "<br /><font color=red>But changes to .htaccess could not be saved. There already exists file .htaccess in root of this script and is not modifyable. Please chmod it to 777 first through your ftp client program. SEO Option currently Turned Off.</font>";
				} else
					$extra = "<br /><font color=green>And changes successfuly saved to .htaccess file.</font>";
			}
		}
		save_temp_file('settings','settings',$stg);		
		
		redirect("$root_path/admin.php?e=".base64_encode("Changes successfully saved..$extra"),0);
		die();
	} else
	
	
	if(act('edituser')) {
		
		if(trim(@$_POST['username']) == '' && trim(@$_POST['email']) == '')
			$center .= eval_template('admin_find_user');
		else {
			switch(@$_POST['option']) {
				case 'u': $USR = user(_html(@$_POST['username'])); break;
				case 'e': $USR = user_by_email(_html(@$_POST['email'])); break;
			}
			if(!$USR) {
				$error = "User not found in databse!";
				$center .= eval_template('admin_find_user');
			} else {
				#edit user
				if($USR['username'] == $settings['admin_user'])
					$center = message("You cannot make changes to Administrator account!");
				else {
					$USR = html_arr($USR);
					$locked = create_combo('locked','Active:N;Banned:Y',$USR['locked']);
					$date = date("F d, Y",$USR['date']); 
					$center .= eval_template("admin_edit_user");
				}
			}
		}
	} else
	if(act('updateuser')) {
		check_magic_quotes();
		$USR = user($_POST['username']);
		if(!$USR)
			$center .= message("Invalid user account ot update! Probably data corruption occured.");
		else {
			if($USR['username'] == $settings['admin_user'])
				$center .= message("You cannot make changes to Administrator account!");		
			else {
				unset($_POST['username']);
				$arr = $_POST;
				if(trim($arr['password']) != '')
					$arr['password'] = md5(trim($arr['password']));
				else
					$arr['password'] = $USR['password'];
					
				foreach($arr as $k => $v) 
					$USR[$k] = trim($v);

					
				save_temp_file('users',strtolower($USR['username']),$USR);
				redirect("$root_path/admin.php?e=".base64_encode("User account '"._html($USR['username'])."' successfully updated..."),0);
				die();
			}
		}
	} else
	if(act('featured')) {
		#list featured images
		if(trim($settings['featured_images']) == '')
			$center = "No featured images found";
		else {
			$imgs = explode(",",trim($settings['featured_images']));
			$images = "";
			foreach($imgs as $img) {
				if($img == "") continue;
				@list($image['iunique'],$image['idate']) = @explode("_",$img);
				$decdate = hexdec($image['idate']);
				$tpath = "$root_path".IMAGE_DIRC.'/thumbs/'.date("Y/F/d",$decdate)."/$image[iunique]_$image[idate].jpg";
				$ipath = "$root_path/share.php?id=$image[iunique]_$image[idate]";
				$images .= eval_template("admin_featured_single");
			}
			$center .= eval_template("admin_featured_images");
		}
	} else
	if(act('feature_image')) {
		include './includes/dpi_ext.php';
		
		$id = _html($_GET['feature_image']);
		$image = load_dpi_image($_GET['feature_image']);
		if(!$image) 
			die("Sorry the destination image could nto be found. Just thub might be available.");
		
		$image = gd_fit($image,300);
		imagejpeg($image,IMAGE_DIR."/featured/$_GET[feature_image].jpg",100);
		
		if($settings['featured_images'] == "")
			$settings['featured_images'] = $id;
		else {
			$settings['featured_images'] = explode(",",$settings['featured_images']);
			array_unshift($settings['featured_images'],$id);
			$settings['featured_images'] = array_unique($settings['featured_images']);
			$settings['featured_images'] = implode(",",$settings['featured_images']);
		}
		switch($settings['filesizeguage']) {
			case 'K': $settings['maxfilesize'] /= 1000; break;
			case 'M': $settings['maxfilesize'] /= 1000000; break;
		}		
		save_temp_file('settings','settings',$settings);
			
		#make small version to load faster
		
		
		#redirect($_SERVER['HTTP_REFERER'],0);
		die("<script>alert('Image successfully added to featured images.');</script>");		
	} else
	if(act('remove_featured')) {
		#list featured images
		if(trim($settings['featured_images']) == '')
			$center = "No featured images found";
		else {
			$imgs = explode(",",trim($settings['featured_images']));
			if(_count($imgs) == 1) {
				redirect("$root_path/admin.php?e=".base64_encode("There is only 1 featured image, you cannot remove it")."&featured",0);			
				die();
			} else {
				foreach($imgs as $k => $img) {
					if(trim($img) ==  $_GET['remove_featured']) {
						unset($imgs[$k]);
						break;
					}
				}
				$stg = $settings;
				switch($stg['filesizeguage']) {
					case 'K': $stg['maxfilesize'] /= 1000; break;
					case 'M': $stg['maxfilesize'] /= 1000000; break;
				}
				
				$stg['featured_images'] = implode(",",$imgs);
				save_temp_file('settings','settings',$stg);
				@unlink(IMAGE_DIR."/featured/$_GET[remove_featured].jpg");
				redirect("$root_path/admin.php?featured",0);			
				die();				
			}
		}
	} else
	if(act('skin')) {
		$arr = trim(template('admin_skin_labels'));
		$arr = str_replace(".tpl","",str_replace("\r","",$arr));
		$arr = explode("\n",$arr);
		
		$x=0;
		foreach($arr as $k => $v) {
			list($tpl,$label) = explode(",",$v);
			$arr[$k] = "<option value=\"$tpl\"".($x==0?" selected":"").">$label</option>";
			$x++;
		} 
		
		$files = Array();
		
		if ($handle = opendir(TEMP_DIR)) {
			while (false !== ($file = readdir($handle))) { 
			   if ($file != "." && $file != ".." && !is_dir(TEMP_DIR."/$file") 
					&& eregi(".tpl",$file) && substr($file,0,5) != "admin"
			   )
					 
			   { 
				 $file = str_replace(".tpl","",$file);
				  $files [] = "<option value=\"$file\">$file.tpl</option>";
			   } 
			}
			closedir($handle); 
		}		
		
		sort($files);
		
		$files = implode("\n",$files);
		$templates = implode("\n",$arr);
		$center = eval_template('admin_select_skin');
	} else
	if(act('editskin')) {
		@chmod("./theme/$settings[theme]/templates",0777);
		if(@$_POST['tpl'] =='')
			$center = message("Please select a template first!");
		else {
			$fn = "./theme/$settings[theme]/templates/$_POST[tpl].tpl";
			if(!file_exists($fn))
				write_file($fn);
				
			$data = _html(load_file($fn));
				
			$center = _html($data);
			$center = eval_template('admin_edit_skin');
		}
	} else
	if(act('updateskin')) {
		check_magic_quotes();
		
		unset($_SESSION["t$_GET[updateskin]"]);
		
		$fn = @"./theme/$settings[theme]/templates/$_GET[updateskin].tpl";
		
		@chmod($fn,0777);
		if(!file_exists($fn) or !is_writable($fn))
			$center = message("ERROR: File is either not writable or does not exist");
		else {
			write_file($fn,$_POST['tpl']);
			if($_GET['updateskin'] == 'css') {
				$cssdata = eval_template("css");
				@chmod("./theme/$settings[theme]/templates/style.css",0777);
				write_file("./theme/$settings[theme]/templates/style.css",$cssdata);
			}
			
			redirect("$root_path/admin.php?skin&e=".base64_encode("Operation completed...\n\nSkin template successfully updated."),0);
			die();
		}
	} else
	if(act('delete_image')) {
		list($uniq,$idate) = explode("_",$_GET['delete_image']);
		$decdate = hexdec($idate);
		$ipath = IMAGE_DIR.'/images/'.@date("Y/F/d",$decdate)."/$_GET[delete_image].jpg";
		$tpath = IMAGE_DIR.'/thumbs/'.@date("Y/F/d",$decdate)."/$_GET[delete_image].jpg";
		$gpath = IMAGE_DIR.'/images/'.@date("Y/F/d",$decdate)."/$_GET[delete_image].gif";
		
		#if(!file_exists($ipath))
		#	die("Image not found - might have already been deleted!");
		
		$i = new iptc($ipath);
		$gallery = $i->get(DPI_GALLERY);
		$author = $i->get(DPI_AUTHOR);
		$has_gif = $i->get(DPI_GIF);
		
		
		if($gallery && $gallery !="") {
			#delete from gallery
			$gal = gallery($gallery);
			if($gal['default_image'] == $_GET['delete_image'])
				$gal['default_image'] = '';
				
			remove_gallery_images($gallery,$gal,Array($_GET['delete_image']));
		} else
		if($author && $author !="") {
			#delete from uncategoriezed
			$user = user($author);
			
			if($user) {
				if($user['avatar'] == $_GET['delete_image'])
					$user['avatar'] = '';
				remove_user_images(Array($_GET['delete_image']),$user);
			} 
		}
		
		#finally delete from public:
		$data = trim(load_file(IMAGE_DIR.'/thumbs/'.@date("Y/F/d",$decdate)."/public.txt"));
		if($data !='') {
			$arr = explode("\n",$data);
			$key = array_search($_GET['delete_image'],$arr);
			if($key !== FALSE) {
				unset($arr[$key]);
				write_file_lock(IMAGE_DIR.'/thumbs/'.date("Y/F/d",$decdate)."/public.txt",implode("\n",$arr));
			}
		}
		
		@unlink($ipath);
		@unlink($tpath);	
		if($has_gif)
			@unlink($gpath);	
		
		
		redirect(trim(@$_GET['ret']) !='' ? base64_decode($_GET['ret']) : "$root_path/index.php",0);
		die();
	} else
	if(act('fix_broken')) {
		@list($year,$month,$day) = explode("_",$_GET['fix_broken']);
		$data = trim(load_file(IMAGE_DIR."/thumbs/$year/$month/$day/public.txt"));
		if($data == "")
			die("Not images in current date to reorganize!");
			
		$images = explode("\n",$data);
		$arr = Array();
		foreach($images as $image) {
			if(strlen($image) > 15) {
				#corrupt image
				$image1 = substr($image,0,strlen($image)/2);
				$image2 = substr($image,strlen($image)/2,strlen($image)/2);
				$arr []= $image1;
				$arr []= $image2;
			} else
				$arr []= $image;
		}
		write_file(IMAGE_DIR."/thumbs/$year/$month/$day/public.txt",implode("\n",$arr)."\n");
		echo "Some changes have been made.";
		redirect("$root_path/images.php?date={$year}_{$month}_{$day}",0);
		die();
	}
	

	echo 
		eval_template("header") .
		eval_template("admin_body") .
		eval_template("footer")
	;
	
?>