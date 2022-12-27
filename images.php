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

	include 'dpi_init.php';
	
	
	if(!act('date')) 
		#display current day images
		@list($year,$month,$day,$page) = explode(".",date("Y.F.d",time()));		
	else 
		@list($year,$month,$day,$page) = explode("_",$_GET['date']);
	
	$year = intval($year);
	$day = intval($day{0} == '0' ? $day{1} : $day);
	$page = intval($page);
	
	if($year==0 or $day==0)
		die("Invalid date detected!");
		
	$month = _html($month);
	
	$day = $day <=9 ? "0$day" : $day;
	
	$admin_fix_broken = 
				$settings['admin_user'] == $logged_user['username'] ? 
				"<a href=\"$root_path/admin.php?fix_broken={$year}_{$month}_{$day}\">Fix Broken Images</a><br><br>"
				:"";
	
	 
	/************* CHECK CACHED PAGE **************************/
	$pfile = IMAGE_DIR."/thumbs/$year/$month/$day/public.txt";
	if(file_exists($pfile)) compare_cache(filemtime($pfile));
	/************* CHECK CACHED PAGE **************************/
	
	$page = intval($page);
	$page = $page < 1 ? 1 : $page;
	
	#make months' links
	$months = cal_get_months($year);
	$cm = date("F",time());
	if(!in_array($cm,$months)) {
		@mkdir(IMAGE_DIR."/images/$year/$cm");
		@mkdir(IMAGE_DIR."/thumbs/$year/$cm");
		write_file(IMAGE_DIR."/images/$year/$cm/index.html","");
		write_file(IMAGE_DIR."/thumbs/$year/$cm/index.html","");
		$months[]= $cm;
	}
	$months_links = '';
	foreach($months as $m) {
		$cls = $m == $month  ? "arc_div_sel_a" : "arc_div_a";
		$months_links .= $settings['seourls'] == 'N' ?
						eval_template("images_archive_month_link") :
						eval_template("images_archive_month_link_seo");
	}
	
	#make days' links
	$days = cal_get_days($year,$month);
	$cd = date("d",time());
	if(!in_array($cd,$days)) {
		@mkdir(IMAGE_DIR."/images/$year/$month/$cd");
		@mkdir(IMAGE_DIR."/thumbs/$year/$month/$cd");
		write_file(IMAGE_DIR."/images/$year/$month/$cd/index.html","");
		write_file(IMAGE_DIR."/thumbs/$year/$month/$cd/public.txt","");
		write_file(IMAGE_DIR."/thumbs/$year/$month/$cd/index.html","");
		$days[]= $cd;
	}	
	$days_links = '';
	foreach($days as $d) {
		$cls = $d == $day ? "arc_div_sel_a" : "arc_div_a";
		
		$days_links .= $settings['seourls'] == 'N' ?
						eval_template("images_archive_day_link") :
						eval_template("images_archive_day_link_seo");
		
	}
	
	
	
	$title = "Image Archive - $year $month, $day";
	
	
	$images= cal_get_images($year,$month,$day);

	$total_images = _count($images);


	if($total_images > $settings['imagesperpage']) {
		$page = intval($page);
		$start = $page < 1 ? 1 : $page;
		$start = ($start * $settings['imagesperpage']) - $settings['imagesperpage'];
		$images = array_slice($images,$start,$settings['imagesperpage']);
		$total_pages = ceil($total_images / $settings['imagesperpage']);
		$cpages_text = "";
		for($i=1; $i<=$total_pages; $i++) {
			$cls = $page == $i ? "arc_div_sel_a" : "arc_div_a";
			$cpages_text .= 
					$settings['seourls'] == 'N' ?
					eval_Template("images_archive_page_link"):
					eval_Template("images_archive_page_link_seo");
		}
	} else 
		$cpages_text = "&nbsp;&nbsp;<i>No extra pages found!</i>";
		

	$x=1;
	$i=0;
	
	if($images) {
		$returl = base64_encode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
		$g_images='';
		foreach($images as $img) {
			if($img == "") continue;
			
			$base = urlencode(base64_encode($img));
			$id=$img;
			
			if($settings['admin_user'] == $logged_user['username'])
				$admin_links = eval_template("image_share_admin");
			
			
			$g_images .= $settings['seourls'] == 'N'?
						eval_template("images_archive_thumb"):
						eval_template("images_archive_thumb_seo");
			
			if($x == $settings['imagesperrow']) {
				$x=1;
				$g_images .= "</tr><tr height=20><td></td></tr><tr>";
			} else 
				$x++;
			$i++;
		}
	} else
		$g_images = "<br><br><br><br><br><h1>No images found in selected date!</h1>";

	$center = eval_template("images_archive");


	echo 
		eval_template("header") .
		eval_template("body") .
		eval_template("footer")
	;
	
	
	
	
	/**********************************************************/
	function cal_get_years() {
		$folder = IMAGE_DIR."/thumbs";
		$gals = Array();
		if ($handle = opendir($folder)) {
			while (false !== ($file = readdir($handle))) { 
			   if ($file != "." && $file != ".." && is_dir("$folder/$file")) { 
				  $gals [] = $file;
			   } 
			}
			closedir($handle); 
		}
		sort($gals);
		return $gals;
	}
	function cal_get_months($year) {
		$folder = IMAGE_DIR."/thumbs/$year";
		$gals = Array();
		if ($handle = @opendir($folder)) {
			while (false !== ($file = readdir($handle))) { 
			   if ($file != "." && $file != ".." && is_dir("$folder/$file")) { 
				  $gals [] = $file;
			   } 
			}
			closedir($handle); 
		}
		
		$monthnames = Array("January","February","March","April","May","June","July","August","September","October","November","December");
		$ret = Array();
		foreach($monthnames as $name) {
			if(in_array($name,$gals))
				$ret []= $name;
		}
		return $ret;
	}
	function cal_get_days($year,$month) {
		
		$folder = IMAGE_DIR."/thumbs/$year/$month";
		$gals = Array();
		if ($handle = @opendir($folder)) {
			while (false !== ($file = readdir($handle))) { 
			   if ($file != "." && $file != ".." && is_dir("$folder/$file")) { 
				  $gals [] = $file;
			   } 
			}
			closedir($handle); 
		}
		sort($gals);
		return $gals;	
	}
	function cal_get_images($year,$month,$day) {
		$public = trim(load_file(IMAGE_DIR."/thumbs/$year/$month/$day/public.txt"));
		if($public && $public != '') 
			return array_reverse(array_remove_empty(explode("\n",str_replace("\r","",("$public")))));
		return false;
	}		
	
?>