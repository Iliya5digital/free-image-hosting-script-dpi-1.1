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


	if($settings['allowuploading'] == '0') {
		#deny uploading
		$center = eval_template("no_uploading");
	} else {


		@list($ms,$defult_module) = explode(":",template('admin_settings_modules_list'));
		$ms = explodE(";",$ms);
		$modules = Array();
		
		foreach($ms as $v) {
			$temp = explode(",",trim($v));
			$modules [$temp[0]] = Array(
				'title'		=>	_html($temp[1]),
				'active'		=>	intval($temp[2]),
				'multiply'	=>	intval($temp[3])
			);
		}
		
		$m_buttons = $m_jsarray = $m_wrappers = Array();
		$tm = time();
		$current_day = date('d',$tm);
		foreach($modules as $k => $module) {
			if($module['active'] == 1) {
				$display = $k==$settings['default_module'] ? "" : "display:none";
				$m_buttons []= eval_template("upload_module_button");
				$m_jsarray [] = "'div_$k'";
				$tdata = eval_template("upload_module_$k");
				$tdata = str_replace("\\\"","\"",$tdata);
				if($module['multiply'] == 1) {
					$temp = '';
					for($i=1; $i<=$settings['maxnumimages']; $i++) {
						$temp .= str_replace("{N}",$i,$tdata);
					}
					$tdata = $temp;
				}
				$m_wrappers []= eval_template("upload_module_wrapper");
				
			}
			
		}
		$m_buttons  = implode("",$m_buttons);
		$m_jsarray  = implode(",",$m_jsarray);
		$m_wrappers = implode("",$m_wrappers);



		$select_gallery = "";
		
		if($logged_user) {
			if($logged_user['galleries'] != '') {
				$galleries_combo = galleries_combo('gid'); 
				$select_gallery = eval_template("upload_gallery_select");
			} else
				$select_gallery = "&nbsp;&nbsp;&nbsp;&nbsp;You did not create a gallery yet. <a href=\"$root_path/mygalleries.php?create\">Click here to create new Gallery</a>";
		} else
			$select_gallery = "&nbsp;&nbsp;&nbsp;&nbsp;Only registered users can maintain galleries.";
		
		$featured_image_path = get_featured_image();
		$upload_image_options = eval_template('upload_image_options');
		$upload_right_box = eval_template('upload_right_box');
		
		$center = eval_template("upload_box");
	}
	
	echo 
		eval_template("header") .
		eval_template("body") .
		eval_template("footer")
	;
			

	

?>