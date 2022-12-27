<br />
<br />
<br />
<b>Welcome $logged_user[username] as Administrator</b>
<br />
<br />
<img src="http://www.image-host-script.com/announcement.php" align="right"
	style="margin-left:15px;margin-bottom:15px;"
>
<h1>Installable updates from official site</h1>
	<div class="desc" align="justify">
		<b>NOTE 1:</b> Make sure current script that you have installed was downloaded from
		image-host-script.com and is genuine <i>without any changes</i>. If your answer is NO, 
		then you need to consult official forum staff before letting this panel install any updates. 
		It is quite possible that some or several scripts might have been changed to download updates from
		non-official sites, which may result in your rscript patched badly, malfunctioning, or even 
		hacked.
		<br />
		<br />
		<b>NOTE 2:</b> Updates are irreversable using this automated Update Manager. You will need to
		reverse them manually, or ask an official-developer that understands the structure of the script.
	</div>
	<br />
	<a href="javascript:check_updates()">Check for Updates now...</a>
	<div id="pgb">
	<br />
	</div>	
	<br />
	<iframe id="fr" style="display:none" class="updates_frame" frameborder="no">
		Loading....
	</iframe>
<script>
	function check_updates() {
		obi('fr').src='$root_path/check_updates.php';
		obi('pgb').innerHTML= "<img src='$root_path/theme/$settings[theme]/images/pgbu.gif' align='center'><br>Please wait while <b>checking for updates...</b>";
		hide('fr');
	}
	function show_fr() {
		show('fr');
	}
	var pimg = new Image();
	pimg.src = '$root_path/theme/$settings[theme]/images/pgbu.gif';
</script>
