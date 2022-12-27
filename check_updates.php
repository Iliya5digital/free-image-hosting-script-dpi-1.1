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
	
	
	echo eval_template('small_header');
	
	
	if(!function_exists('gzuncompress')) {
		echo "
		<center>
		<br />
		<br />
		<br />
		<b>CANNOT RETRIEVE UPDATES</b>
		<br />
		<br />
		ERROR: function <b>gzuncompress</b> not found. Zlib Extension not loaded on server. 
		<br />
		Please contact your server administrator and request this extension installation.
		</center>
		".throw_end();
		die();
	}
	
	if($settings['admin_user'] != @$logged_user['username']) die("Authorization denied!".throw_end());


	#check for upates
	define('UPDATES_PATH',"http://www.image-host-script.com");
	
	if(act('clear')) {
		$ufile = base64_decode($_GET['clear']);
		if(!@unlink(ATA_DIR."/updates/$ufile"))
			die("Cannot remove the update from data folder 'updates'".throw_end());	
		else
			echo "<li> <font color=green>Update successfuly removed from history</font>
				<a href='$root_path/check_updates.php'>Click here to refresh list</a>
				";
		
	}
	if(act('install')) {
		session_unset();
		session_destroy();
		$ufile = base64_decode($_GET['install']);
		$data = @file_get_contents(UPDATES_PATH."/dpi_updates/$ufile");
		if($data === FALSE)
			die("Unable to download Update from remote site...".throw_end());
		else {
			$error= false;
			$upd = get_single_update_binary($data);
			echo "<ul type='i'>";
			echo "<li> Verifying package - <b>$upd[0]</b>";
			if(_count($upd) < 4) {
				echo "<li> <font color=red>ERROR: Insufficient data in package (probably corrupt package file).</font>";
				$error=true;
			} else {	
				
				echo "<li> Starting updatation process...";
				$files = array_slice($upd,3,100);
				echo "<ul>";
				$datafiles = $errors = Array();
				foreach($files as $bin) {
					@list($filename,$filedata) = @explode("<---W--->",$bin);
					$filename = trim(str_replace("\r","",str_replace("\n","",$filename)));
					if(file_exists($filename)) {
						if(!is_writable($filename)) {
							$errors []= "<li> $filename is not writable, chmod it to 777";
							$error=true;
							continue;
						} else
							$datafiles [$filename]= $filedata;
					} else
						$datafiles [$filename]= $filedata;
				}
				if(!empty($errors)) {
					echo implode("\n",$errors);
				} else
					foreach($datafiles as $filename => $filedata) {
						$res = write_file($filename,uncompress_bin($filedata));
						if(!$res) {
							echo "<li> Critical Error - cannot write $filename";
							$error=true;
							break;
						} else
							echo "<li> Updated $filename (<i>".strlen($filedata)." bytes</i>)";
					}				
				echo "</ul>";
			}
			if($error)
				echo "<li> <font color=red>Update installation encountered error..</font>";
			else {
				write_file(DATA_DIR."/updates/$ufile",$data);
				echo "<li> <font color=green>Update installation was sussessful..</font>
				<a href='$root_path/check_updates.php'>Click here to refresh list</a>
				";
			}
			
			echo "</ul>";
			die();
		}
	}
	
	
	#list updates
	

	$data = @file_get_contents(UPDATES_PATH."/dpi_updates/index.php?updates");
	
	if($data === FALSE)	die("Remote site did not respond in timely manner. Please check updates after while.".throw_end());
		
	if($data == "")	die("No updates available.".throw_end());
	
	$already  = get_installed_updates();
	
	$arr = explode("###",$data);
	$updates= "";
	$i=0;
	foreach($arr as $rfile) {
		@list($file,$size) = @explode(":",$rfile);
		$date = date("F d, Y h:i:s A",intval($file));
		if(!in_array($file,$already)) {

			$udata = file_get_contents(UPDATES_PATH."/dpi_updates/$file");
			if($udata !== FALSE) {
				
				$upd = get_single_update_binary($udata);
				$upd[2] = "<li>".str_replace(",","<li>",$upd[2]);
				$file = urlencode(base64_encode($file));
				$updates .= eval_template("update_new_row");
			}
		}
		$i++;
	}
	#list installed
	foreach($already as $file) {
		$date = date("F d, Y h:i:s A",intval($file));	
		$upd = get_single_update_installed($file);
		$file = urlencode(base64_encode($file));
		$updates .= eval_template("update_old_row");		
	}

	echo
		eval_template('updates_table').
		throw_end();
	
	######################################################################
	
	function get_installed_updates() {
		$arr = array();
		if ($handle = opendir(DATA_DIR."/updates")) {
			
		    while (false !== ($file = readdir($handle))) { 
			   if ($file != "." && $file != ".." && !is_dir("./$file") && $file != ".htaccess") { 
				  $arr[]= $file;
			   } 
		    }
		    closedir($handle); 
		}
		return  $arr;
	}
	
	function get_single_update_installed($fname) {
		if(!file_exists(DATA_DIR."/updates/$fname")) return false;
		$data = load_file(DATA_DIR."/updates/$fname");
		return explode("<---S--->",uncompress_bin($data));
	}
	function get_single_update_binary($data) {
		return explode("<---S--->",uncompress_bin($data));
	}	
	
	function uncompress_bin($data) {
		$txt = @gzuncompress($data);
		if(!$txt) return $data;
		return $txt;
	}

	function throw_end() {
		echo "<script>
			parent.document.getElementById('pgb').innerHTML = '';
			parent.document.getElementById('fr').style.display='';
		</script>";
	}

?>