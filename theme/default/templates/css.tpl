	body {
		margin-top:0px;
		margin-left:0px;
		margin-right:0px;
		margin-bottom:0px;
		background-color:#777777;
		color:black;
		background-image:url("$root_path/theme/$settings[theme]/images/page_bg.gif");
	}
	td,input,div,textarea,select {
		font-family:Arial;
		font-size:12px;
	}
	select {
		background-color:#CBCBED;
	}
	h1 {
		font-size:16px;
		color:#FF6600;
	}
	.quote {
		padding-left:50px;
		padding-right:50px;
	}
	a {
		font-family:Arial;
		font-size:12px;
		color:#3939AE;
		text-decoration:none;
	}
	.table_100 {
		width:100%;
	}
	.table_50 {
		width:60%;
	}
	.input_normal_full {
		width:100%;
	}
	.table_main {
		border-left:1px solid #222222;
		border-right:1px solid #222222;
		border-bottom:1px solid #222222;
		border-top:0px;
		width:90%;
		border-collapse:collapse;
	}
	.td_header {
		padding:0px;
		padding-left:10px;		
		background-image:url("$root_path/theme/$settings[theme]/images/header_bg.jpg");
		width:60%;
	}
	.td_header_right {
		color:white;
		padding:0px;
		background-image:url("$root_path/theme/$settings[theme]/images/header_bg.jpg");
		width:40%;
	}	
	.td_header a {
		color:white;
		text-decoration:none;
		font-size:13px;
	}
	.td_header_right a {
		color:white;
		text-decoration:none;
		font-size:13px;
	}	
	.td_top_links {
		height:25px;
		background-color:white;
		border-top:3px solid #DDDDDD;
		border-bottom:3px solid #DDDDDD;
		border-right:1px solid #444444;
		border-left:1px solid #444444;
		padding:0px;
		background-image:url("$root_path/theme/$settings[theme]/images/mbbg.jpg");
	}
	.link_home {
		padding-left:12px;
		padding-right:12px;
		padding-top:6px;
		padding-bottom:6px;
		color:white;
		font-family:Arial;
		font-size:12px;
		font-weight:bold;
		background-color:#444444;
		text-decoration:none;
		line-height:25px;
		background-image:url("$root_path/theme/$settings[theme]/images/link_top_bg.jpg");
	}
	.link_home:hover {
		background-color:black;
		background-image:url("$root_path/theme/$settings[theme]/images/link_top_bg.jpg");
	}
	.link_top {
		padding-left:12px;
		padding-right:12px;
		padding-top:6px;
		padding-bottom:6px;
		color:#444444;
		font-family:Arial;
		font-size:12px;
		text-decoration:none;
		line-height:25px;
	}	
	.link_top:hover {
		color:white;
		background-color:#777777;
		background-image:url("$root_path/theme/$settings[theme]/images/link_top_bg.jpg");
	}	
	.td_center {
		background-color:white;
		color:black;
		padding:1em;
	}
	.td_footer {
		background-color:#eeeeee;
		color:gray;
		padding:.5em;
		text-align:right;
	}
	.td_footer a {
		color:#333333;
		text-decoration:none;
	}
	.td_footer a:hover {
		color:#F69220;
	}

	.simple {
		color:black;
	}
	.simple_white {
		color:#444444;
	}
	.msgbox {
		color:gray;
		padding:.7em;
		background-color:white;
		border:1px dashed gray;
	}
	.td_upload_choice {
		vertical-align:top;
		background-color:#ffffff;
		/*padding:10px;*/
		border-bottom:1px solid #eeeeee;
		color:gray;
	}
	.td_upload_choice button {
		cursor:pointer;
		/*width:100px; */
		padding-top:5px;
		padding-bottom:5px;
		background-color:white;
		color:gray;
		border-top:1px solid #eeeeee;
		border-left:1px solid #eeeeee;
		border-right:2px solid gray;
		border-bottom:0px;
	}
	.td_upload_box {
		width:80%;
		text-align:left;
		vertical-align:top;
		padding-top:20px;
		padding-left:50px;
		color:black;
	}
	.td_upload_right {
		padding:20px;
		text-align:center;
		vertical-align:top;
		color:gray;
	}
	.div_adv_opt {
		padding:10px;
		text-align:left;
		color:black;
	}
	.div_adv_opt img { cursor:pointer;
	}
	.field_file {
		width:150px;
		cursor:default;
	}
	.field_file_zip {
		width:250px;
		cursor:default;
	}	
	.field_url {
		width:150px;
	}
	.code_image {
		border:1px solid black;
	}
	.code_box {
		border:1px solid gray;
		background-color:white;
		color:#3C3CB5;
		width:500px;
		cursor:pointer;
		font-family:tahoma;
		font-size:10px;
	}
	.code_box_full {
		border:1px solid gray;
		background-color:white;
		color:#3C3CB5;
		width:100%;
		cursor:pointer;
		font-family:tahoma;
		font-size:10px;
	}	
	.code_table {
		background-color:#f4f4f4;
		width:100%;
		border-left:5px solid gray;
		border-bottom:1px solid #dddddd;
		border-right:1px solid #dddddd;
		border-top:1px solid #dddddd;
	}
	.td_code_fields {
		vertical-align:center;
		text-align:left;
	}
	.td_code_image {
		width:$settings[thumbxy];
		vertical-align:center;
		text-align:center;
		padding:10px;
	}
	.highlight_row_right {
		text-align:right;
		vertical-align:center;
		background-color:#eeeeee;
		padding:5px;
	}
	.td_gallery_left {
		width:200;
		color:black;
		background-color:white;
		vertical-align:top;
	}
	.td_gallery_right {
		color:black;
		background-color:white;
		vertical-align:top;
		padding-left:20px;
		text-align:right;
	}
	.td_gallery_thumb {
		vertical-align:bottom;
		text-align:center;
	}
	.gallery_thumb { border:1px solid black; }
	.gallery_thumb:hover {
		filter:Gray;
	}	
	.td_gallery_thumb a:hover {
		opacity:0.4;
		filter:alpha(opacity=40);
	}
	
	.td_gallery_thumb_select{
		text-align:center;
		color:black;
	}
	.highlight_row_left {
		background-color:#eeeeee;
		padding:10px;
		color:black;
	}
	.heading_block { 
		background-image:url("$root_path/theme/$settings[theme]/images/headbg.jpg");
		background-repeat: no-repeat;
		color:black; 
		padding-top:5px;
		padding-bottom:5px;
		padding-left:15px;
		display:block;
		height:25px;
	}		
	.featured_image {
		width:300px; 
		border-left:3px solid #eeeeee;
		border-top:3px solid #eeeeee;
		border-right:3px solid #333333;
		border-bottom:3px solid #333333;
		padding:5px;
	}
	.share_image_frame { 
		width:700px; 
		overflow-x:auto; 
		/*overflow-y:auto; */
		vertical-align:center;
		text-align:center;
	} 
	.user_gallery_left_div { 
		width:180px; 
		overflow-x:auto; 
		white-space:nowrap;
		padding-right:10px;
		border-right:5px solid #EEEEEE;
	} 	
	.td_gallery_desc {
		color:gray;
		padding:.3em;
		width:150px;
		vertical-align:top;
	}
	.desc {
		color:black;
		font-size:11px;
	}
	.bio {
		color:gray;
		align:justify;
	}
	.admin_form {
		background-color:white;
		width:98%;
		border-left:1px solid #dddddd;
		border-top:25px solid #dddddd;
		border-right:1px solid gray;
		border-bottom:2px solid gray;
		padding:.8em;
		color:black;
	}	
	.admin_menu_td {
		text-align:left;
		vertical-align:top;
		color:black;
		width:150px;
	}
	.admin_menu_td a {
		color:black;
		text-decoration:none;
		font-size:11px;
	}
	.admin_menu_td a:hover {
		text-decoration:underline;
	}	
	.admin_menu_td a img {
		border:0px;
	}	
	.admin_body_td {
		padding-left:20px;
	}
	.updates_frame {
		border:1px dotted gray;
		width:100%;
		height:400px;
	}
	.preview_img {
		border:1px solid #eeeeee;
		width:32px;
		height:17px;
	}
	.bookmarks {
		text-align:right;
		
	}
	.bookmarks a img {
		border:0px;
	}
	.pages {
		text-align:center;
	}
	.pages a {
		padding:4px;
		border:1px solid gray;
		background-color:#eeeeee;
		
		text-decoration:none;
		font-weigt:bold;
		color:black;
	}
	.share_info {
		font-size:13px;
		color:gray;
		text-align:center;
	}
	.arc_div {
		background-color:#f4f4f4;
		border-left:5px solid gray;
		padding-left:15px;
		padding-top:10px;
		padding-right:7px;
		padding-bottom:10px;
		border-bottom:1px solid #DDDDDD;
		border-right:1px solid #DDDDDD;
	}
	.arc_div_a {
		border:1px solid #dddddd;
		background-color:white;
		color:gray;
		padding:3px;
	}
	.arc_div_a:hover {
		background-color:gray;
		color:white;
		border:1px solid black;
	}
	.arc_div_sel_a {
		padding:3px;
		background-color:gray;
		color:white;
		border:1px solid black;	
	}
	.td_archive_thumb {
		vertical-align:bottom;
		text-align:center;
	}
	.td_archive_thumb a img { border:0px; }
	.archive_thumb { border:0px; }
	
	