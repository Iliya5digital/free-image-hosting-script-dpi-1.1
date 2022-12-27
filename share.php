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
	

	$id = _html(@$_GET['id']);
	
	if(@$settings['seourls']=='Y')
		$image_path = "$root_path/image-$id.jpg";
	else
		$image_path = "$root_path/image.php?id=$id";
		
		
	$ad1 = eval_template("ad1");
	$ad2 = eval_template("ad2");
	if($settings['admin_user'] == $logged_user['username'])
		$admin_links = eval_template("image_share_admin");


	@list($tid,$xdate) = @explode("_",$id);
	$date = hexdec($xdate);
	
	$file = IMAGE_DIR."/images/".@date("Y/F/d",$date) ."/$id.jpg";
	
	$fadate = @date("F d, Y",@fileatime($file));
	$fcdate = @date("F d, Y",$date);
	$fmdate = @date("F d, Y",@filemtime($file));
	
	$rate_id = base64_encode(@$id);
	$filesize = sprintf("%.2f",@filesize($file) / 1000);
	
	$size = @getimagesize($file);
	$i = new iptc($file);
	
	$gif = "jpg";
	
	if($i->hasmeta) {
	
		$is_gif = trim($i->get(DPI_GIF));
		if($is_gif == "GIF") {
			$gif = "gif";
			if(@$settings['seourls']=='Y')
				$image_path = "$root_path/image-$id.gif";
			else
				$image_path = "$root_path/image.php?id=$id&gif";
		}
	
		$image_title = $i->get(DPI_TITLE);
		if($image_title !='')
			$title = "$image_title - $title";
			
		$author = $i->get(DPI_AUTHOR);
		if($author != "" && $author!==FALSE) {
			$author = _html($author);
			$author_link = 
				$settings['seourls'] == 'Y' ?
				eval_template("image_share_author_link_seo") :
				eval_template("image_share_author_link");
		}
		
		$gallery = $i->get(DPI_GALLERY);
		if($gallery != "" && $gallery!==FALSE) {
			$gal = gallery($gallery);
					
			$images = explode(",",$gal['images']);
			$nlink = $plink = "";
			if(_count($images) > 1) {
				$curr = array_search($id ,$images);
				if($curr > 0) {
					#previous link
					$pimage = $images[$curr-1];
					$plink = 
						$settings['seourls'] == 'Y' ?
						eval_template("image_share_plink_seo") :
						eval_template("image_share_plink");
				}
				if($curr < _count($images)-1) {
					#next link
					$last_image = $images[_count($images)-1];
					$nimage = $images[$curr+1];
					$nlink = 
						$settings['seourls'] == 'Y' ?
						eval_template("image_share_nlink_seo") :
						eval_template("image_share_nlink");
				}				
			}
			
			$galtitle_in_link = str_replace(" ","+",_html($gal['title']));
			$gallery_link = 
					$settings['seourls'] == 'Y' ?
					eval_template("image_share_gallery_link_seo") :
					eval_template("image_share_gallery_link");			
		}
		$rating = $i->get(DPI_RATING);
		if(trim($rating) == '') {
			$rating_msg = "Image has not yet been rated.";
			$rating_box = eval_template("image_share_rating_box");
		} else {
			#there is rating of image, already
			
			$image_width = 14;
			$total_width = $image_width * 5;
			
			@list($n,$r) = explode(":",$rating);
			
			$rating = ($r / $n);
			
			$g_rating = ceil(($rating / 5) * $total_width);
			$b_rating = $total_width - $g_rating;
			$rating_msg = "$g_rating, $b_rating";
			$rating = sprintf("%.2f",$rating);
			$rating_msg = eval_template("image_share_rating_stars");
			
			if(!isset($_COOKIE[md5($id)]) and !isset($_SESSION[md5($id)])){
				#let him/her rate 
				$rating_box = eval_template("image_share_rating_box");
			} 
			
		}
	} else {
		$rating_msg = "Image has not yet been rated.";
		$rating_box = eval_template("image_share_rating_box");	
	}
	
	$rating = eval_template("image_share_rating");
		
	$codes = eval_template(@$settings['seourls']=='Y' ? "image_code_seo" : "image_code");
		
	$center = eval_template("image_share");

	echo 
		eval_template('header').
		eval_template('body').
		eval_template('footer');
		
	

?>