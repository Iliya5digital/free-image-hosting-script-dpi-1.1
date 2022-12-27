<form method="post" action="./admin.php?updateskin=$_POST[tpl]">
<h1>Integrated Skin Edior &gt; "$_POST[tpl]"</h1>
<br />
Please do not disturb variables (words starting with dollar sign \$), and do not disturb the code 
within &lt;script&gt;&lt;/script&gt; tags, which may result in malfunctioning of your script interface.

<br />
<br />
<textarea wrap="off" name="tpl" id="tpl" rows="25" style="font-size:10px;font-family:verdana;color:blue" class="input_normal_full">$data</textarea>
<br />
<br />
<input type="submit" value="Update Template">
</form>
<script>
	obi('tpl').focus();
</script>