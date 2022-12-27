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
	
	DEFINE("DPI",		TRUE);
	DEFINE('YES', 		1);
	DEFINE('NO',  		0);
	DEFINE('D_EXT',  	'txt');
	DEFINE('DATA_DIR',  './data');
	DEFINE('IMAGE_DIR',	'./graphic');
	DEFINE('IMAGE_DIRC','/graphic');
	define('CX_NONEZ', "");
	define('CX_NONES', "CNILL");	
	define('CX_CODES', "CODES");	
	

	function load_file($filename,$all=true) {
		if(!@is_readable($filename)) return false;
	
		$f = @fopen($filename,"r");
		$data = @fread($f,$all ? filesize($filename) : $all);
		@fclose($f);
		return $data;
	}

	function write_file($filename,$data="") {
		$f = @fopen($filename,"w");
		if(!$f) return false;
		@fwrite($f,$data);
		@fclose($f);
		return true;
	}
	function write_file_lock($filename,$data="") {
		$f = @fopen($filename,"w");
		if(!$f) return false;
		@flock($f,LOCK_EX);
		@fwrite($f,$data);
		@flock($f,LOCK_UN);		
		@fclose($f);
		return true;
	}	
	function append_new($fname,$arr) {
		$odata = trim(load_file($fname));
		$odata = explode("\n",$odata);
		$odata = array_merge($odata,$arr);
		$odata = implode("\n",$odata);
		write_file_lock($fname,$odata);
	}
	function append_file($fname,$data) {
		$f = @fopen($fname,"a+b");
		if(!$f) return false;
		@fwrite($f,$data);
		@fclose($f);
	}	

	function template($fname) {
		
		if(isset($_SESSION["t$fname"])) return $_SESSION["t$fname"]; 
		
		$tfile = TEMP_DIR."/$fname.tpl";
		if(!file_exists($tfile))
			return "<br /><b>warning</b> : missing template - $fname<br />";
		
		$data = load_file($tfile);
		$data = str_replace("\"","\\\"",$data);
		
		$_SESSION["t$fname"] = $data;

		return $data;
	}	
	function eval_template($tpl) {
		global 	$START_TIME,$WIPED_TIME;
	
		if($tpl == "footer") {
			list($usec, $sec) = explode(" ", microtime()); 
			$WIPED_TIME = ((float)$usec + (float)$sec); 
			$WIPED_TIME = sprintf("%.3f",$WIPED_TIME-$START_TIME);
		}
		
		$tpl_data = template($tpl);	
		$arr = array(); 
		if( preg_match_all('/\$\w+/', $tpl_data, $matches) ) { 
			$arr = array_unique($matches[0]); 
			foreach($arr as $v) {
				$v = str_replace('$','',$v);
				global ${"$v"};
			}
		} 
		@eval("\$temp=\"$tpl_data\";");
		
		return $temp;
	}	
	function get_unique_filename($time=false,$length=4) {
		$ip = $_SERVER['REMOTE_ADDR'];
		$long = sprintf("%u",ip2long($ip));
		
		$unique = rand(rand(0,100),$long).rand(rand(0,100),$long).rand(rand(0,100),$long);
		$unique .= crypt(rand(100,$long),time()) . microtime();
		
		$unique = substr(md5($unique),0,$length);
		return strtoupper($unique.'_'.dechex($time ? $time : time()));
	}	
	function get_todays_folder(&$thumbs,&$images) {
		$dir = "{root}/".date("Y/F/d",time());
		$thumbs = str_replace("{root}",IMAGE_DIR."/thumbs",$dir);
		$images = str_replace("{root}",IMAGE_DIR."/images",$dir);
		if(!create_dir($thumbs)) return false;
		if(!create_dir($images)) return false;
		return true;
	}
	function array_remove_empty($arr) {
		foreach($arr as $k=>$v)
			if(trim($v) == "")
				unset($arr[$k]);
		$ran = substr(md5(time().crypt('k')),0,10);
		return explode($ran,implode($ran,$arr));
		
	}	
	
	function create_dir($path,$extra_file="index.html",$data="") {
		if(is_dir($path)) return true;
		$path = str_replace("./","{R}",$path);
		$path = explode("/",$path);
		$dir = "";
		foreach($path as $cdir) {
			if($cdir == "") continue;
			$cdir = str_replace("{R}","./",$cdir);
			$dir .= eregi("./",$cdir) ? $cdir : "/$cdir";
			if(!@is_dir($dir)) {
				if(!@mkdir($dir))
					return false;
				@chmod($dir,0777);
				if($extra_file)
					write_file("$dir/$extra_file",$data);
			}
		}
		return true;
	}	
	if(!function_exists('gzuncompress')) {
		function gzcompres($flat) { return $flat; }
		function gzuncompres($flat) { return $flat; }
	}
	if(!function_exists('file_get_contents')) {
		function file_get_contents($url) { return @implode("",file($url)); }
	}


	$redirect_time = 3;
	function redirect($red,$time=-1) { 
		global $redirect_time;
		$redirect_time = $time==-1 ? $redirect_time : $time;
		echo "<META http-equiv=\"refresh\" content=\"$redirect_time;URL=$red\">" .
		($redirect_time > 0 ?
		"<a href='$red'>Click here if you are not redirected automatically in $redirect_time seconds</a>"
		:''); 
	}
	function alert($data) {
		echo "<script>alert(\"$data\");</script>";
	}
	function _count($arr) { return is_array($arr) ? (empty($arr) ? 0 : count($arr)) : 0; }
	function act($vname) { return isset($_GET[$vname]);	}	
	function pct($vname) { return isset($_POST[$vname]);	}	
	function html_arr($arr){
		foreach($arr as $k => $v)
			$arr[$k] = _html($v);
		return $arr;
	}
	function valid_email($email) {
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	function check_magic_quotes() {
		if(get_magic_quotes_gpc())
			foreach($_POST as $key => $val)
				$_POST[$key] = trim(stripslashes($val));
	}	
	function valid_characters($username) {
		$username = trim($username);
		$chars = explode(",","A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,0,1,2,3,4,5,6,7,8,9,-,_, ");
		
		$ret = "";
		for($i=0; $i<strlen($username); $i++)
			if(in_array($username{$i}, $chars))
				$ret .= $username{$i};
			
		return $ret;
	}
	function valid_galery_name_characters($username) {
		$username = trim($username);
		$chars = explode(",","A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,0,1,2,3,4,5,6,7,8,9,-,_, ");
		
		$ret = "";
		for($i=0; $i<strlen($username); $i++)
			if(in_array($username{$i}, $chars))
				$ret .= $username{$i};
		
		$ret = str_replace("-","_",$ret);
		$ret = str_replace(" ","+",$ret);
		
		return $ret;
	}	
	function _html($keys) { return htmlspecialchars($keys, ENT_QUOTES); }
	function _ip() { return $_SERVER['REMOTE_ADDR']; }
	function truncstr($var,$size=10) {
		if(strlen("$var") <= $size) return $var;
		return substr($var,0,$size)."...";
	}	
    function remotefsize($url) {
    
	   $purl = parse_url($url);
    
        $sch = $purl['scheme'];
        if (($sch != "http") && ($sch != "https") && ($sch != "ftp") && ($sch != "ftps")) {
            return false;
        }

	   if (($sch == "http") || ($sch == "https")) {
            $headers = array_change_key_case(get_headers_x($url,1),CASE_LOWER);
            if ((!array_key_exists("content-length", $headers))) { return 0; }
            return $headers["content-length"];
        } 	        
    }	
    function get_headers_x($url,$format=0, $user='', $pass='', $referer='') {
        if (!empty($user)) {
            $authentification = base64_encode($user.':'.$pass);
            $authline = "Authorization: Basic $authentification\r\n";
        }

        if (!empty($referer)) {
            $refererline = "Referer: $referer\r\n";
        }

        $url_info=parse_url($url);
        $port = isset($url_info['port']) ? $url_info['port'] : 80;
        $fp=fsockopen($url_info['host'], $port, $errno, $errstr, 30);
        if($fp) {
            $head = "GET ".@$url_info['path']."?".@$url_info['query']." HTTP/1.0\r\n";
            if (!empty($url_info['port'])) {
                $head .= "Host: ".@$url_info['host'].":".$url_info['port']."\r\n";
            } else {
                $head .= "Host: ".@$url_info['host']."\r\n";
            }
            $head .= "Connection: Close\r\n";
            $head .= "Accept: */*\r\n";
            $head .= @$refererline;
            $head .= @$authline;
            $head .= "\r\n";

            fputs($fp, $head);       
            while(!feof($fp) or ($eoheader==true)) {
                if($header=fgets($fp, 1024)) {
                    if ($header == "\r\n") {
                        $eoheader = true;
                        break;
                    } else {
                        $header = trim($header);
                    }

                    if($format == 1) {
                    $key = array_shift(explode(':',$header));
                        if($key == $header) {
                            $headers[] = $header;
                        } else {
                            $headers[$key]=substr($header,strlen($key)+2);
                        }
                    unset($key);
                    } else {
                        $headers[] = $header;
                    }
                } 
            }
            return $headers;

        } else {
            return false;
        }
    }	   
	function create_combo($name,$values,$sel=1,$onchange="",$extra="") {
		global $settings,$skin;
		$ret="<select name='$name' onchange=\"$onchange\"$extra>\n";
		$items=explode(";",$values);
		
		for($i=0; $i<count($items); $i++) {
			$temp=explode(":",$items[$i]);
			$select="";
			if(_count($temp)==1) $temp[1] =$temp[0];			
			if(trim($temp[1])=="$sel") 
				$select=" selected";

			$ret .="\t<option value='$temp[1]'$select>$temp[0]</option>\n";
		}
		$ret .="</select>\n";
		return $ret;
	}	    

	function message($nmsg) {
		global $message;
		$message = $nmsg;
		return eval_template("message");
	}	
		
	#1.1b additions, enhanced 1.1Final
	function get_url_contents($url,&$err,$timeout=3,$limitsize=1000000) {
		if(CURL_READING) {
			$res = curl_get_web_page($url, $timeout);
			if($res['errno'] != 0) {
				$err = $res['errmsg'];
				return false;
			} else 
			if($res['size'] > $limitsize) {
				$err = "Too large remote file - "._html($url);
				return false;
			} else
				return $res['content'];
		} else
		if(URL_READING) 
			return simp_get_web_page($url, $err, $timeout, $limitsize);
		else {
			$err = "Server support is poor: Library 'CURL' not found on server, neither 'fopen' is allowed to read URLs.";
			return false;
		}
		#no need to return anything, all handles already
	}
	function simp_get_web_page($url,&$err,$timeout=3,$limitsize=1000000) {
		if(!URL_READING) return false;
		$f = @fopen($url,"r");
		if(!$f) {	$err = "Cannot read from remote URL - "._html($url); return false;}
		$data = "";
		$start_t = time();
		while($bytes = @fread($f,1024)) {
			$data .= $bytes;
			if(time()-$start_t > $timeout) {
				@fclose($f);
				$err = "Url is taking too long to respond - "._html($url);
				return false;
			} else
			if(strlen($data) > $limitsize) {
				@fclose($f);
				$err = "Too large remote file - "._html($url);
				return false;
			}
		}
		@fclose($f);
		if(trim($data)=="") { $err="Empty remote file - "._html($url); return false; }
		return $data;
	}
	if(!function_exists('curl_setopt_array')) {
		function curl_setopt_array(&$ch, $array) 
		{
			foreach($array as $k => $v) 
			{
				curl_setopt ( $ch, $k, $v);
			}
		}
	}
	function curl_get_web_page( $url, $timeout=3) { #3 seconds
		$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => false,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_ENCODING       => "",
			CURLOPT_USERAGENT      => "DPI 1.1b",
			CURLOPT_AUTOREFERER    => true,
			CURLOPT_CONNECTTIMEOUT => $timeout,
			CURLOPT_TIMEOUT        => $timeout,
			CURLOPT_MAXREDIRS      => 10, #if third set right
		);

		$ch      = curl_init( $url );
				 curl_setopt_array($ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		$size = $header['size_download'];
		curl_close( $ch );

		$header['size']   = $size;
		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		return $header;
	}		
	
	
	function compare_cache($date) {
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			$last_modified = gmdate('D, d M Y H:i:s',intval("$date")).' GMT';
			
			$if_modified_since = preg_replace('/;.*$/', '', $_SERVER['HTTP_IF_MODIFIED_SINCE']);
	
			if ($if_modified_since == $last_modified) {
				header("HTTP/1.0 304 Not Modified");
				header("Cache-Control: max-age=86400, must-revalidate");
				
			}
		}
		

		return false;	
	}	
	
?>