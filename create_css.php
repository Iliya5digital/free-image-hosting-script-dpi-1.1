<?

	#temporary file
	#DELETE it After the installation is complete


	include ('dpi_init.php');
	
?>
<center>
<br><br><br>
<?
	@chmod("./theme/default/templates/style.css",0777);
	@chmod("./theme/default/templates",0777);
	$data = eval_template("css");
	if(!write_file("./theme/default/templates/style.css",$data)) {
		die("Cannot write file to <b>theme/default/templates</b> folder, please chmod it to 777 and refresh this page by hitting F5 key.");
	}
	@unlink("create_css.php");
		
	echo "Installation is fully complete. Please <a href='./index.php'>click here to browse your script</a>.";


?>
</center>