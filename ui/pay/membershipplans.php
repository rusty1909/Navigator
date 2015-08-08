<div class="frmDronpDown">
	<div class="row">
		<label><b> Please Select an Payment Option: </b>  </label>
		<select name="country" id="country-list" class="demoInputBox" onChange="getState(this.value);">
            <option value="3" selected="selected">Activation + Due Amount (<?php echo $payHelper->GetPaymentByPayCode(3); ?> /- Only)</option>
            <option value="2">Activation (<?php echo $payHelper->GetPaymentByPayCode(2); ?> /- Only)</option>
            <option value="1">Due Amount (<?php echo $payHelper->GetPaymentByPayCode(1); ?> /- Only)</option>
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
