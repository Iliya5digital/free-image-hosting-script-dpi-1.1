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
	
	$title = "User Gallery";
	
	
	$g_list = "";
	
	
	$gid = _html(@$_GET['id']);
	$cgal = gallery($gid);
	
	
	
	if(!$cgal)
		$center = message("Invalid gallery link followed!");
	else {
		#GALLERIES DISLAY
		
		/************* CHECK CACHED PAGE **************************/
		compare_cache(mdate_temp_file('galleries',$gid));
		/************* CHECK CACHED PAGE **************************/
		
		$cgal = html_arr($cgal);
		$cgal['username'] = str_Replace(' ','+',$cgal['username']);
		
		$viewable=true;
		#authenticate admin ro view everything
		if($settings['admin_user'] != @$logged_user['username']) {
			
			if($cgal['password'] != "" && @$logged_user['username'] != $cgal['username']) {
				if(@$_SESSION["g_$gid"] != md5($cgal['password'])) 
					$viewable=false;
					
				if(act('log')) {
					$error = "";
					if(md5(@$_POST['password']) != $cgal['password'])  {
						$error = "Invalid password supplied";
					} else {
						#log here
						$_SESSION["g_$gid"] = md5($cgal['password']);
						redirect("$root_path/gallery.php?id=$gid",0);
						die();
					}
				}
			
			}
		}
		if(!$viewable) 
			$center = eval_template("gallery_password");
		else {
			$title = str_replace("\n"," ",$cgal['title']);
			$images = explode(",",$cgal['images']);
			$total_images = count($images);
			
			
			$start = 0;
			if($total_images > $settings['imagesperpage']) {
				$page = intval(@$_GET['page']);
				$page = $page < 1 ? 1 : $page;
				$start = $page < 1 ? 1 : $page;
				$start = ($start * $settings['imagesperpage']) - $settings['imagesperpage'];
				$images = array_slice($images,$start,$settings['imagesperpage']);

				$total_pages = ceil($total_images/$settings['imagesperpage']);
				$pages_text = "";
				 
				$gtitle = str_replace(" ","_",_html($cgal['title']));
				
				for($i=1; $i<=$total_pages; $i++) {
					$cls = $i== $page ? "arc_div_sel_a" : "arc_div_a";
					$pages_text .= 
						$settings['seourls'] == 'N'?
						eval_template("gallery_page_link"):
						eval_template("gallery_page_link_seo");
				}
				
			}
			
			
			$g_images = "";
			
			if($total_images==0 or trim($cgal['images'])=='')
				$g_images = message("Gallery is currently empty");
			else {
				$x=1;
				$i=0;
				
				$returl = base64_encode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
				
				foreach($images as $img) {
					if($img == "") continue;
					
					$base = urlencode(base64_encode($img));
					$id=$img;
					
					if($settings['admin_user'] == $logged_user['username'])
						$admin_links = eval_template("image_share_admin");			
					
					
					$g_images .= $settings['seourls'] == 'N' ?
								eval_template("gallery_thumb") :
								eval_template("gallery_thumb_seo") ;
								
					
					if($x == $settings['imagesperrow']) {
						$x=1;
						$g_images .= "</tr><tr height=20><td></td></tr><tr>";
					} else 
						$x++;
					$i++;
				}
			}
			
			$cgal['date'] = @date("F d, Y [h:i:s A]",$cgal['date']);
			$cgal['update'] = @date("F d, Y [h:i:s A]",$cgal['update']);
			
			$center = eval_template("gallery");
			
			$meta_tags = eval_template("gallery_meta_tags");
			
		}
	}

	echo 
		eval_template('header').
		eval_template('body').
		eval_template('footer');
		
		
	
?>