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
	
	REQUIRE_ONCE( 'dpi_init.php' );
	
	$title = "Gallery Archive";
	
	
	$gals = array();
	if ($handle = opendir(DATA_DIR."/galleries")) {
	    while (false !== ($file = readdir($handle))) { 
		   if ($file != "." && $file != ".." && !is_dir(DATA_DIR."/galleries/$file") && $file != ".htaccess") { 
			  $gals [$file]= filectime(DATA_DIR."/galleries/$file");
		   } 
	    }
	    closedir($handle); 
	}	
	asort($gals, SORT_NUMERIC);
	
	/************* CHECK CACHED PAGE **************************/
	if(!empty($gals)) compare_cache(max($gals));
	/************* CHECK CACHED PAGE **************************/
	
	
	$gals = array_reverse($gals);
	$gals = array_keys($gals);
	
	
	$total_galleries = _count($gals); 
	
	$start = 0;
	#more pages / slice resource
	if($total_galleries > $settings['imagesperpage']) {
		$page = intval(@$_GET['page']);
		$page = $page < 1 ? 1 : $page;
		$start = $page < 1 ? 1 : $page;
		$start = ($start * $settings['imagesperpage']) - $settings['imagesperpage'];
		#get current page slice
		$gals = array_slice($gals,$start,$settings['imagesperpage']);

		$total_pages = ceil($total_galleries/$settings['imagesperpage']);
		
		
		$pages_text = "";
		for($i=1; $i<=$total_pages; $i++) {
			$cls = $i == $page ? "arc_div_sel_a" : "arc_div_a";
			$pages_text .= 
					$settings['seourls'] == 'N' ?
					eval_template("archive_page_link") :
					eval_template("archive_page_link_seo");
		}
	} else
		$pages_text = "&nbsp;&nbsp;<i>No more pages</i>";
	
	$g_images = "";
	
	if($total_galleries==0)
		$g_images = message("No Galleries have been created yet");
	else {
		$x=1;
		$i=0;
		
		foreach($gals as $gal) {
			$gid = str_replace(".".D_EXT,"",$gal);
			$gal = gallery($gid);
			if(!$gal) continue;
			
			$gal = html_arr($gal);
			
			$gal['title'] = substr($gal['title'],0,25);
			if($settings['seourls'] == 'N')
				$ipath = "$root_path/gallery.php?id=$gid";
			else {
				$ipath = "$root_path/gallery-".valid_galery_name_characters($gal['title'])."-$gid.html";
				$ipath = str_replace("+","_",$ipath);
			}
			
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
			
			$g_images .= eval_template("archive_thumb");
			
			if($x == $settings['imagesperrow']) {
				$x=1;
				$g_images .= "</tr><tr height=20><td></td></tr><tr>";
			} else 
				$x++;
			$i++;
		}
	}
	$center = eval_template("archive");	
	
	

	echo 
		eval_template("header") .
		eval_template("body") .
		eval_template("footer")
	;
	
	
	
	

?>