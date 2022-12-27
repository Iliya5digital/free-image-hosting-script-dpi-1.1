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
		redirect("$root_path/login.php",0);
		die();
	}
	
	if(act('update')) {
		$ref = $_SERVER['HTTP_REFERER'];
		$imgs = isset($_POST['images']) ? $_POST['images'] : (isset($_REQUEST['images']) ? $_REQUEST['images'] : false);
		
		if(is_array($imgs)) $imgs = html_arr($imgs);
		$Oimgs = $imgs;
		$imgs = @implode(",",$imgs);
		if(!$imgs or $imgs=="")
			$center = message("No images selected to perform any action over!");
		else {
			if(@$_POST['act'] == "d") { 
				#delete images
				
				$imgs = explode(",",$imgs);
				
				$was_gal=false;
				if($_POST['sgid'] != "" && $_POST['sgid'] != '0') {
					$was_gal = gallery(_html($_POST['sgid']));
					if($was_gal && $was_gal['username'] == $logged_user['username']) {
						$images = explode(",",$was_gal['images']);
						$temp = Array();
						foreach($imgs as $d) {
							$key = array_search($d,$images);
							if($key !== FALSE) {
								$temp[]=$images[$key];
								unset($images[$key]);
								
							}
						}
						$imgs = $temp;
						$was_gal['images'] = implode(",",$images);
						save_temp_file('galleries',$_POST['sgid'],$was_gal);
					}
				} else {
					#delete uncategorized images
					$images = explode(",",$logged_user['images']);
					$temp = Array();
					foreach($imgs as $d) {
						$key = array_search($d,$images);
						if($key !== FALSE) {
							$temp[]=$images[$key];
							unset($images[$key]);
						}
					}
					$imgs = $temp;
					$logged_user['images'] = implode(",",$images);
					save_temp_file('users',strtolower($logged_user['username']),$logged_user);
				}
				
			
				foreach($imgs as $image) {
					list($extra,$idate) = explode("_",$image);
					$idate = hexdec($idate);
					unlink(IMAGE_DIR."/images/".date("Y/F/d",$idate)."/$image.jpg");
					unlink(IMAGE_DIR."/thumbs/".date("Y/F/d",$idate)."/$image.jpg");
					unlink(IMAGE_DIR."/images/".date("Y/F/d",$idate)."/$image.gif");
				}
				redirect($_SERVER['HTTP_REFERER'],0);	
				#redirect("$root_path/mygalleries.php?id=0&e=".base64_encode("Selected image(s) successfully deleted."),1);
				die();
				
			} else
			if(@$_POST['act'] == 'c') {
				redirect("$root_path/misc.php?showseries=".urlencode(base64_encode(_html($imgs))),0);
				die();
			}
			else
			if(@$_POST['act'] == 'a') {
				#set avatar
				$logged_user['avatar'] = $Oimgs[0];
				save_temp_file('users',strtolower($logged_user['username']),$logged_user);
				echo "Profile mage successfuly set!";
				redirect($_SERVER['HTTP_REFERER'],0);
				
				
			} else
			if(@$_POST['act'] == "m") {#move images
				
				$_POST['sgid'] = @$_POST['sgid']=="0" ? "" : @$_POST['sgid'];
				$_POST['gid'] = @$_POST['gid']=="0" ? "" : @$_POST['gid'];
				
				if( _html(@$_POST['gid']) == _html(@$_POST['sgid']) )
					$center = message("No files moved, source and destination is same.");
				else {
			
					#sgid	from
					#gid 	to 	#selection
					$gallery1=$gallery2=false;
					if($_POST['sgid'] != "") {
						$gallery1 = gallery(_html(@$_POST['sgid']));
						if(!$gallery1)	die("Invalid source gallery pointed!");
						if(@$gallery1['username'] != $logged_user['username'])
							die("2.Invalid source gallery pointed");
					}
					if($_POST['gid'] != "") {
						$gallery2 = gallery(_html(@$_POST['gid']));
						if(!$gallery2)	die("Invalid target gallery pointed!");
						if(@$gallery2['username'] != $logged_user['username'])
							die("2.Invalid target gallery pointed");
					}	
					
					if($gallery1)
						$myimages = explode(",",$gallery1['images']); #source images
					else
						$myimages = explode(",",$logged_user['images']); #source images
					
					
					$incomming = explode(",",$imgs);

					$my_only = Array();
					foreach($incomming as $img) {
						if(array_search($img,$myimages) !== FALSE) 
							$my_only []= $img;
						
					}
					if(!empty($my_only)) {
						if($gallery1) 
							#remove from gallery
							remove_gallery_images(_html($_POST['sgid']),$gallery1, $my_only);
						else 
							#remove from user
							remove_user_images($my_only,$logged_user);
							
							
						#NOW ADD 
						if($gallery2) {
							#add to target gallery
							add_gallery_images(_html($_POST['gid']),$gallery2, $my_only);
							foreach($my_only as $image) {
								list($id,$xdate) = @explode("_",$image);
								eval("\$idate = 0x$xdate;");
								$imagefile = IMAGE_DIR.'/images/'.date("Y/F/d",$idate)."/{$id}_{$xdate}.jpg";
								set_image_gallery($imagefile,_html(@$_POST['gid']));
							}
						} else {
							#add to user acc
							add_user_images($my_only);
							foreach($my_only as $image) {
								list($id,$xdate) = @explode("_",$image);
								eval("\$idate = 0x$xdate;");
								$imagefile = IMAGE_DIR.'/images/'.date("Y/F/d",$idate)."/{$id}_{$xdate}.jpg";
								set_image_gallery($imagefile,"");
							}
						}
						
					}
					redirect($_SERVER['HTTP_REFERER'],1);
					die();
				}
				
			} else 
			if(@$_POST['act'] == "s") { #set a defautl image
				$was_gal = gallery(_html($_POST['sgid']));
				if($was_gal && $was_gal['username'] == $logged_user['username']) {
					$was_gal['default_image'] = $Oimgs[0];
					save_temp_file('galleries',$_POST['sgid'],$was_gal);
				}
				redirect("$root_path/mygalleries.php?id="._html($_POST['sgid'])."&e=".base64_encode("Default image/icon has successfully been set."),1);
				die();
			}			
		}
		
		
		
	} else
	if(act('create')) {
		$title = "Create New Gallery";
		$center =eval_template("gallery_create");
	} else
	if(act('process')) {
		
		#create gallery here
		$error = "";
		check_magic_quotes();
		
		if(strlen(@$_POST['title']) <3) 
			$error = "Too short gallery title supplied, it must be atleast 3 characters.";
		else 
		if(valid_characters(trim(@$_POST['title'])) != trim(@$_POST['title']))
			$error = "Invalid characters found in gallery title, please use A-Z, 0-9, '-', '_' and space character.";
		else
		if(strlen(@$_POST['password']) >10) 
			$error = "Too large Password, maximum is 10 characters";
		else 
		if(md5(strtoupper(@$_POST['captcha'])) != @$_SESSION["usercap"]) 
			$error = "Inalid security code entered";
			
		if($error != "") {
			$_POST = html_arr($_POST);
			$center =eval_template("gallery_create");
		} else {
		
			#ADD TO DATABASE
			unset($_POST['captcha']);
			
			$arr = get_temp_array('galleries');
			
			$arr['title'] 		= substr($_POST['title'],0,100);
			$arr['description'] = substr($_POST['description'],0,500);
			$arr['tags'] 		= substr($_POST['tags'],0,100);
			$arr['username'] 	= $logged_user['username'];
			$arr['password'] 	= trim($_POST['password']) != "" ? md5(trim($_POST['password'])) : "";
			$arr['date'] 		= time();
			$gal_name = get_unique_filename();
			
			save_temp_file('galleries',$gal_name,$arr);
			add_gallery_to_user($gal_name,$_POST['title']);
			
			redirect("$root_path/mygalleries.php?id=$gal_name",1);
			
			die();		
		}		
		
		
	} else
	if(act('delete')) {
		$gal = gallery(_html($_GET['delete']));
		if(!$gal)
			$center = message("Requested gallery not found for deletion.");
		else
		if($gal['username'] != $logged_user['username'])
			$center = message("Invalid gallery id supplied!");
		else {
			#DELETE GALLERY HERE
			#delete images first
			$images = explode(",",$gal['images']);
			
			if(delete_user_gallery(_html($_GET['delete']))) { #remove gallery footprints
				#delete attached images
				foreach($images as $img) {
					@list($image['iunique'],$image['idate']) = @explode("_",$img);
					$decdate = hexdec($image['idate']);
					$tpath = IMAGE_DIR.'/thumbs/'.date("Y/F/d",$decdate)."/$image[iunique]_$image[idate].jpg";
					$ipath = IMAGE_DIR.'/images/'.date("Y/F/d",$decdate)."/$image[iunique]_$image[idate].jpg";
					@unlink($ipath);
					@unlink($tpath);
				}
			} 
			redirect("$root_path/mygalleries.php?id=0",0);
			die();
			
		}
			
	} else
	if(act('edit')) {
		$gid  =_html($_GET['edit']);
		$gal = gallery($gid);
		if(!$gal)
			$center = message("Requested gallery not found for editting.");
		else
		if($gal['username'] != $logged_user['username'])
			$center = message("Invalid gallery id supplied!");
		else {
			$gal =html_arr($gal);
			if(act('save')) {
				check_magic_quotes();
				
				$error = "";
				check_magic_quotes();
				
				if(strlen(@$_POST['title']) <3) 
					$error = "Too short gallery title supplied, it must be atleast 3 characters.";
				else 
				if(valid_characters(trim(@$_POST['title'])) != trim(@$_POST['title']))
					$error = "Invalid characters found in gallery title, please use A-Z, 0-9, '-', '_' and space character.";
				else
				if(strlen(@$_POST['password']) >10) 
					$error = "Too large Password, maximum is 10 characters";
					
				if($error != "") {
					$center =eval_template("gallery_edit");
				} else {	
					#update gallery here
					$arr = $gal;
					
					$arr['title'] 		= substr($_POST['title'],0,100);
					$arr['description'] = substr($_POST['description'],0,500);
					$arr['tags'] 		= substr($_POST['tags'],0,100);
					$arr['update'] 		= time();
					switch(@$_POST['option']) {
						case 'remove': $arr['password'] = ''; break;
						case 'new': $arr['password'] = trim(@$_POST['password'])=='' ? '' :  md5(substr(trim(@$_POST['password']),0,10));
							
					}
					save_temp_file('galleries',$gid,$arr);
					redirect("$root_path/mygalleries.php?id=0&e=".base64_encode("Gallery updated successfully"),0);
					die();
				}
				
			} else {
				$already = $gal['password'] == "" 
							? "No password has been set to this gallery."
							: "Password is alreday set.";
				$center = eval_template('gallery_edit');
			}
		}		
	}
	
	
	#list gallery or uncategorized
	else {
		if(act('e')) {
			@list($msg,$url) = explode("^",base64_decode($_GET['e']));
			$top_message = message("".nl2br($msg) . ($url!='' ?"<br><br><br><a href=\"$url\">Click here to continue.</a>":''));
		}
	
		$g_list = "";
		
		
		$gid = _html(@$_GET['id']);
		
		
		#galleries list
		$galleries = explode(",",$logged_user['galleries']);
		$cgal = false;
		foreach($galleries as $gal) {
			if($gal=="" or !eregi(':',$gal)) continue;
			$gal=explode(":",$gal);
			$gal['title'] = $gal[0];
			$gal['id'] = $gal[1];
			if($gal[1] == $gid) {
				$cgal = gallery($gal['id']);
				$gal['title'] = "<b>$gal[title]</b>";
			}
			$g_list .= eval_template("gallery_gal_link");
		}
		#GALLERIES DISLAY
		$images = Array();
		if($cgal) {
			$images = explode(",",$cgal['images']);
		} else {
			$cgal['title'] = "Uncategories images";
			$images = explode(",",$logged_user['images']);
		}
		$total_images = count($images);
		$start = 0;
		if($total_images > $settings['imagesperpage']) {
			$page = intval(@$_GET['page']);
			$start = $page < 1 ? 1 : $page;
			$start = ($start * $settings['imagesperpage']) - $settings['imagesperpage'];
			$images = array_slice($images,$start, $settings['imagesperpage']);
			
			$total_pages = ceil($total_images/$settings['imagesperpage']);
			$pages_text = "Pages: ";
			for($i=1; $i<=$total_pages; $i++) {
				$script = "mygalleries";
				$pages_text .= eval_template("gallery_user_page_link");
			}
		}
		
		
		$galleries_combo = galleries_combo('gid');
		$g_images = "";
		
		if($total_images==0)
			$g_images = message("Empty");
		
		$x=1;
		$i=0;
		foreach($images as $img) {
			if($img == "") continue;
			$base = urlencode(base64_encode($img));
			$g_images .= 
						$settings['seourls'] == 'N' ?
						eval_template("gallery_thumb_user"):
						eval_template("gallery_thumb_user_seo");
			if($x == $settings['imagesperrow']) {
				$x=1;
				$g_images .= "</tr><tr height=20><td></td></tr><tr>";
			} else 
				$x++;
			$i++;
		}
		
		$prev_link = $cgal ? eval_template("gallery_user_preview_link") : "";
			
		
			
		$center = eval_template("gallery_user");
	}
	

	echo 
		eval_template('header').
		eval_template('body').
		eval_template('footer');
		




?>