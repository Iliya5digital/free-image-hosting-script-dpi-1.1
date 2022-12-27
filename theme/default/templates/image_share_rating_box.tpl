<select id="rating">
	<option value="0" selected>Select rating</option>
	<option value="1">Worst</option>
	<option value="2">Not bad</option>
	<option value="3">Good</option>
	<option value="4">Best</option>
	<option value="5">Excelent</option>
</select>
<input type="button" value="rate" 
	onclick="javascript:
		rval = parseInt(obi('rating').value);
		if(rval==0)
			alert('Please a rating first!');
		else
			obi('rfr').src='$root_path/misc.php?rate=$rate_id&rating='+rval;
	"
>
		
<iframe id="rfr" style="display:none"></iframe>