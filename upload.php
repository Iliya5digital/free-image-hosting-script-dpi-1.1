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
	REQUIRE_ONCE('./includes/dpi_ext.php');
	
	
	
	if($settings['allowuploading'] == '0') {
		#deny uploading
		$center = eval_template("no_uploading");
	} else 
	if((@$_POST['typ'] == 'z' or @$_POST['typ'] == 'w') and !$logged_user)
		$center = message("Sorry this option is available to registered users only!");
	else{
	
		$tfolder = get_todays_folder($th,$im);
		if(!$tfolder) die("Critical ERROR 1: Report to administrator please");
		$currtime = time();
							
		if($logged_user && intval(@$logged_user['next_upload_time']) > time() && $settings['admin_user'] != @$logged_user['username'])
			$center = message("Extensive use detected! Administrator has set a time interval of ".($settings['upload_interval']/60)." minutes. Please try again after ".sprintf("%.2f",$logged_user['next_upload_time']-time())." seconds.");
		else
		if(!$logged_user && (intval(@$_SESSION['next_upload_time']) > time()  || intval(@$_COOKIE['next_upload_time']) > time()) )
			$center = message("Extensive use detected! Administrator has set a time interval of ".($settings['upload_interval']/60)." minutes. Please try again after ".sprintf("%.2f",(intval(@$_SESSION['next_upload_time']) > intval(@$_COOKIE['next_upload_time']) ? @$_SESSION['next_upload_time'] : @$_COOKIE['next_upload_time'])-time())." seconds.");
		else {
			#upload here
			$files = false;
			if(@$_POST['typ'] == 's')
				$files = Array(@$_FILES['f_single']);
			else 
			if(@$_POST['typ'] == 'm') {
				unset($_FILES['f_single']);
				unset($_FILES['f_zip']);
				$files = $_FILES;
			} else 
			if(@$_POST['typ'] == 'u' || @$_POST['typ'] == 't' || @$_POST['typ'] == 'd' || @$_POST['typ'] == 'w') {
				unset($_FILES);
				$files = false;
			}
			
			$errors = $uniques = Array();
			$hasgid=_html(@$_POST['gid']);

			
	
			#attach uploaded images to gallery
			$is_gallery = 0;
			if($hasgid != "" && $logged_user) {
				$gal = gallery(_html($_POST['gid']));
				if($gal) {
					if($gal['username'] == $logged_user['username']) {
						$is_gallery=_html($_POST['gid']);
					} else {
						$is_gallery=0;
						die("Gallery '"._html($gal['title'])."' does not belong to your account.");
					}
				} 
			}
			
			if(!$files) {
				if(@$_POST['typ'] == 'z') {
					REQUIRE_ONCE( './includes/tpi_pclzip.php' );
					check_magic_quotes(); 
					if($_FILES['f_zip']['size'] == 0)
						$errors []= "Corrupt zip file supplied!";
					else
					if($_FILES['f_zip']['size'] > $settings['maxnumimages']*$settings['maxfilesize'])
						$error []= "Large zip file supplied - maximum size ".sprintf("%.2f kb",($settings['maxnumimages']*$settings['maxfilesize'])/1000);
					else {
					
						if(ZIP_READING) {
							#USE NATIVE ZIP FUNCTIONS
							$zip = zip_open($_FILES['f_zip']['tmp_name']);

							if ($zip) {

							    while ($zip_entry = zip_read($zip)) 
							    {
									if (zip_entry_open($zip, $zip_entry, "r")) 
									{
										$zfn = zip_entry_name($zip_entry);
										$data = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
										if ($data != "" and $data != false) {
											$image = @imagecreatefromstring($data);
											if(!$image) 
												$errors []= "Not a supported image file format (or no an image) in ZIP://"._html($zfn);
											else 	
												$uniques[]= Array(2, $image);
										} else
											$errors []= "Probably empty file - ZIP://"._html($zfn);
										unset($data);
									  
									  zip_entry_close($zip_entry);
									}
							    }
							    zip_close($zip);
							} else
								$errors []= "Cannot open zip file for reading - "._html($_FILES['f_zip']['tmp_name']);
							
							
						} else {
						
							/**************** PLC ZIP EXTENTION *******************/
							$zip = new PclZip($_FILES['f_zip']['tmp_name']);
						
							if ($zip) 
							{
							  $ufolder = ip2long($_SERVER['REMOTE_ADDR']) + time() + rand(99,9999);
							  $ufolder = IMAGE_DIR."/temp/$ufolder";
							  mkdir($ufolder);
							  $res = $zip->extract(PCLZIP_OPT_PATH, $ufolder, PCLZIP_OPT_REMOVE_ALL_PATH);
							  if($res == 0) 
								$errors [] = "Library error: ".$zip->errorInfo(true);
							  else 
							  {
								  if ($handle = opendir($ufolder)) 
								  {
									  while (false !== ($file = readdir($handle))) 
									  { 
										if(is_dir("$ufolder/$file") or $file=='.' or $file=='..') continue;
											
										$type = dpi_supported("$ufolder/$file");
										if ($type) 
											$uniques[]= Array($type,file_get_contents("$ufolder/$file"));
										else
											$errors []= "Not a supported image file format in ZIP://"._html($file);
										
										@unlink("$ufolder/$file");
									  }
								 }
							  }
							} else
								$errors []= "Cannot open zip file for reading - "._html($_FILES['f_zip']['tmp_name']);
							@rmdir($ufolder);
							/**************** PLC ZIP EXTENTION *******************/
						}
					}
				} else				
				if(@$_POST['typ'] == 't') {
					check_magic_quotes();
					$text = trim(substr(@$_POST['text'],0,5000));
					if($text =="")
						$errors []= "No text found to create image from!";
					else {
						#create image from text
						$text = str_replace("\t","    ",$text);
						
						$padding = intval($_POST['tpadding']);
						$pading = $padding > 100 ? 100 : $padding;
						$pading = $padding < 0 ? 0 : $padding;
						
						
						$fsize = intval($_POST['tsize']);
						$fsize = $fsize > 36 ? 36 : $fsize;
						$fsize = $fsize < 8 ? 8 : $fsize;
						$ttf  ="./theme/fonts/"._html($_POST['tfont']).".ttf";
						$size = imagettfbbox($fsize, 0, $ttf, $text);
						
						$xsize = abs($size[0]) + abs($size[2])+($padding*2);
						$ysize = abs($size[5]) + abs($size[1])+($padding*2);
						
						$image = imagecreate($xsize, $ysize);
						
						$bgcolor = gd_hexgd($image,$_POST['tbgcolor']);
						$fgcolor = gd_hexgd($image,$_POST['tcolor']);
						
						imagettftext($image, $fsize, 0, $padding, $fsize+$padding, $fgcolor, $ttf, $text);
						
						$uniques []= Array(2, $image);
					}
				} else
				if(@$_POST['typ'] == 'u') {
					$compose = Array();
					for($i=1; $i<=$settings['maxnumimages']; $i++) {
						$uval = $_POST["u_".date("d",time())."$i"];
						if(strlen(trim($uval)) > 6)
							$compose []= $uval;
					}
					foreach($compose as $remote_url) {
						$ferr = "";
						
						$remote_url = str_replace(" ","%20",trim($remote_url));
						
						$type = dpi_supported($remote_url);
						if(!$type) 
							$errors []= "Not a valid image URL - "._html($remote_url);
						else {
						
							$data = get_url_contents(
								$remote_url,
								$ferr,
								3, #timeout 3 seconds
								$settings['maxfilesize']
							);						
							if(!$data) {
								$errors []= $ferr;
								continue;
							}
							
							$uniques []= Array($type,$data);
							
							unset($data);
						}
					}
				} else
				if(@$_POST['typ'] == 'w') {
					$remote_url = trim(@$_POST['theurl']);
					$remote_url = str_replace(" ","%20",trim($remote_url));
					
					$data = get_url_contents(
								$remote_url,
								$ferr,
								3, #timeout 3 seconds
								$settings['maxfilesize']
							);
							
					if(!$data) 
						$errors []= "Cannot contact remote url - "._html($remote_url);
					else {
						preg_match_all( '/img(.*)src=(")(.*)(")/', $data, $match ) ; 
						
						$match = array_unique(@$match[3]);
						
						foreach($match as $remote_url) {
							if(eregi('"',$remote_url)) 
								@list($remote_url,$extra) = explode('"',$remote_url);
						
							$remote_url = str_replace(" ","%20",trim($remote_url));
						
							$type = dpi_supported($remote_url);
							if(!$type) 
								$errors []= "Not a valid image URL in page - "._html($remote_url);
							else {
							
								$data = get_url_contents(
									$remote_url,
									$ferr,
									3, #timeout 3 seconds
									$settings['maxfilesize']
								);						
								if(!$data) {
									$errors []= $ferr;
									continue;
								}
								
								$uniques []= Array($type,$data);
								
								unset($data);
							}
						}						
					}
				}
			} else {
				#general upload
				$files = array_slice($files,0,$settings['maxnumimages']);
				foreach($files as $file) {
					if($file['name'] == '')
						continue;
						
					if($file['size'] > 0) {
						if($file['size'] > $settings['maxfilesize']) {
							$errors []= "Too large input file - $file[name] - $file[size]";
							continue;
						}
						$type = dpi_supported($file['tmp_name']);
						if(!$type) 
							$errors []= "Not a valid image file - $file[name]";
						else {
							$data = @load_file($file['tmp_name']);
							$uniques[]= Array($type,$data);
							unset($data);
						}
					} else 
						$errors []= "Corrupt or empty file - $file[name]";
				}
			}
			
			if(!empty($uniques)) {
				#proces files here
				$NUinuqes=Array();
				$x=1;
				

				$can_handle_iptc = Array('s','m','u','t');	
				
				foreach($uniques as $cimg) {
					$image = $cimg[1];
					if(is_string($image))
						$image = @imagecreatefromstring($image);
						
					#background fix 1.1
					$image = gd_set_bg($image,"FFFFFF");
					
					if(isset($_REQUEST['fliph']) || isset($_POST['fliph'])) 
						$image = gd_flip_h($image);
												
					if(isset($_REQUEST['flipv']) || isset($_POST['flipv'])) 
						$image = gd_flip_v($image);			
									
					if(isset($_REQUEST['rotate90']) || isset($_POST['rotate90'])) 
						$image = gd_rotate($image,-90,"FFFFFF");
						
					if(isset($_REQUEST['rotate180']) || isset($_POST['rotate180'])) 
						$image = gd_rotate($image,180);
						
					if(isset($_REQUEST['rotate270']) || isset($_POST['rotate270'])) 
						$image = gd_rotate($image,90);
						
						
					#1.1f addition
						
					if(isset($_REQUEST['resize']) || isset($_POST['resize'])) {
						$resW = intval(@$_POST['resizeW']);
						$resH = intval(@$_POST['resizeH']);
						if($resW  < 1) $resW = 1;
						if(isset($_REQUEST['asratio']) || isset($_POST['asratio'])) 
							$image = gd_fit($image,$resW);
						else {
							if($resH  < 1) $resH = 1;
							$image = gd_resize($image,$resW,$resH);
						}
					}
					
					if(isset($_REQUEST['shear_r']) || isset($_POST['shear_r'])) 
						$image = shear_r($image,60,"FFFFFF");
						
					if(isset($_REQUEST['shear_l']) || isset($_POST['shear_l'])) 
						$image = shear_l($image,60,"FFFFFF");
						
					if(isset($_REQUEST['scanl_h']) || isset($_POST['scanl_h'])) 
						$image = scanlines_h($image,1,100);
						
					if(isset($_REQUEST['scanl_v']) || isset($_POST['scanl_v'])) 
						$image = scanlines_v($image,1,100);
					
						
												
					$id = get_unique_filename($currtime);
					#create thumb
					$thumb = gd_fit($image,$settings['thumbxy']);
					
					#Accomodate image options
					if(isset($_REQUEST['border']) || isset($_POST['border'])) 
						gd_rectangle($image,0,0,gd_width($image)-1,gd_height($image)-1,"000000");
					if(isset($_REQUEST['bordert']) || isset($_POST['bordert'])) 
						gd_rectangle($thumb,0,0,gd_width($thumb)-1,gd_height($thumb)-1,"000000");
					if(isset($_REQUEST['watermark']) || isset($_POST['watermark'])) 
						gd_3db_watermark($image,"./theme/$settings[theme]/images/watermark.png");						

					#save thmb first
					imagejpeg($thumb,"$th/$id.jpg",$settings['thumbuality']);
					imagedestroy($thumb);
					#then save actual jpeg
					imagejpeg($image,"$im/$id.jpg",$settings['quality']);
					imagedestroy($image);
					
					$iptc = new iptc("$im/$id.jpg");
					if($cimg[0] == 1) {
						#it is gif keep in data
						write_file("$im/$id.jpg",load_file("$th/$id.jpg"));
						write_file("$im/$id.gif",$cimg[1]);
						$iptc->set(DPI_GIF,"GIF");
					}
					
					
					if(in_array(@$_POST['typ'],$can_handle_iptc)) {
						switch(@$_POST['typ']) {
							case 's': {	
								$iptcstr = substr(@$_POST['cap_single'],0,100);
								if(strlen(trim($iptcstr)) >0) {
									$iptc->set( DPI_TITLE ,_html(trim($iptcstr)));
								}
								break;
							}
							case 'm': {
								$iptcstr = @$_POST["cap$x"];
								if(strlen(trim($iptcstr)) >0) {
									$iptcstr = substr($iptcstr,0,100);
									$iptc->set( DPI_TITLE ,_html(trim($iptcstr)));
								}
								break;
							}	
							case 'u': {
								$iptcstr = @$_POST["ucap$x"];
								if(strlen(trim($iptcstr)) >0) {
									$iptcstr = substr($iptcstr,0,100);
									$iptc->set( DPI_TITLE ,_html(trim($iptcstr)));
								}
								break;
							}	
							case 't': {	
								$iptcstr = trim(substr(@$_POST['ttitle'],0,100));
								if(strlen(trim($iptcstr)) >0) 
									$iptc->set( DPI_TITLE ,_html(trim($iptcstr)));

								check_magic_quotes();
								$text = trim(substr(@$_POST['text'],0,5000));								
								$iptc->set( DPI_SOURCE ,gzcompress(trim($text)));
								break;
							}							
							
							
						}
					}
					if($logged_user) {
						$iptc->set(DPI_AUTHOR,$logged_user['username']);
						$iptc->set(DPI_GALLERY,$hasgid);
					}
					$iptc->write();	
											
					$NUinuqes []= $id;	
					$x++;
				}	
				$uniques = $NUinuqes;			
				if(!isset($_POST['private'])) 
					append_new("$th/public.txt",$uniques);					
				
			}
			if(!empty($uniques)) {
				if( $logged_user) {
					add_images_to_user(array_reverse($uniques),$hasgid);
				} else {
					$sess_name = 's_'.md5(_ip());
					if(isset($_SESSION[$sess_name])) {
						$temp = explode(",",$_SESSION[$sess_name]);
						$temp = array_merge($uniques,$temp);
						$_SESSION[$sess_name] = implode(",",$temp);
						$uniques = $temp;
					} else
						$_SESSION[$sess_name] = implode(",",$uniques);
						
					$_SESSION['next_upload_time'] = time() + intval($settings['upload_interval']);
					setcookie('next_upload_time',time() + intval($settings['upload_interval']),time()+3600,"/",$cdomain);
				}
			}
			
			$msg = !empty($errors) ? "&e=".base64_encode(implode("\r",$errors)) : (empty($uniques) ? "e=".base64_encode("No files uploaded!") : CX_NONEZ);
			if(count($uniques) > 30) {
				$_SESSION['CODES'] = implode(",",$uniques);
				$base64ed = CX_CODES;
			} else
			$base64ed = urlencode(base64_encode(implode(",",$uniques)));
			$REDIRECT_PATH = "$root_path/".($is_gallery ? "mygalleries.php?id=$is_gallery" : "misc.php?".(!empty($uniques)?"showseries=".$base64ed: CX_NONES )  ) . '&'.$msg;
			
			touch(DATA_DIR."/LID",time(),time());
			
			redirect($REDIRECT_PATH,0);
			die();
				
			
		}
	}
	
	echo 
		eval_template('header').
		eval_template('body').
		eval_template('footer');
		
	
?>