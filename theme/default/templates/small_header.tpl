<style>
	body,td,div,input,select {
		font-family:arial;
		font-size:12px;
		color:black;
	}
	body {
		margin-left:10px;
		margin-right:10px;
		margin-top:1px;
		margin-bottom:1px;
	}
	.desc {
		color:gray;
	}
	a {
		text-decoration:none;
		color:blue;
	}
	a:hover {
		color:green;
		text-decoration:underline;
	}
</style>
<script>
function showhide(id){ 
	if (document.getElementById){ 
		obj = document.getElementById(id); 
		if (obj.style.display == 'none'){ 
			obj.style.display = ''; 
		} else { 
			obj.style.display = 'none'; 
		} 
	} 
} 
</script>