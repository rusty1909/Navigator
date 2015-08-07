<div class="frmDronpDown">
	<div class="row">
		<label><b> Please Choose a Membership Plan: </b>  </label><br />
		<select name="country" id="country-list" class="demoInputBox" onChange="getState(this.value);">
		<option value="">Select Membership Plan</option>
                <option value="1987" selected="selected">Premium Yearly Plan(For a year, just 12000/-)</option>
                <option value="1989">Premium Monthly Plan (For a month, just 1200/-)</option>
                <option value="1984">Reader Yearly Plan(For a year, just 6000/-)</option>
                <option value="1985">Reader Monthly Plan (For a month, just 600/-)</option>
		</select>
	</div>
</div>


<script>    
function getState(val) {
    console.log(val);
	$.ajax({
	type: "POST",
	url: "getPlan.php",
	data:'planID='+val,
	success: function(data){
		//$("#state-list").html(data);
        if(data){
            console.log(data);
            resultObj = eval (data);
            console.log(resultObj);
            document.getElementsByName("amount")[0].value = resultObj[1];  
            document.getElementsByName("productinfo")[0].value = resultObj[0];  
            document.getElementsByName("productcode")[0].value = resultObj[2];  
            
            $("#userMessage").empty();
          }else{
            console.log('error detected');
          }
	}
	});
}
</script>
