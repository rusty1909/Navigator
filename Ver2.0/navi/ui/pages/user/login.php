<?php 
//header('content-type: application/json; charset=utf-8');
require_once "../../../utility/helper/Common/CommonHelper.php"; 
 
if(User::isLoggedIn())
	       header('Location: index.php');

require_once "../../master/headerhomehtml.php";
?>
<script>
    
window.jsonpcallback = function (data) { 
if(data == null){
    console.log("data is null");
    return;
}
	alert(data);
    JSON.stringify(data);
    console.log("logged"+data);
    if(data == 1){
        alert(data);
        window.location.href = 'http://portal.findgaddi.com/';
    }else if(data == 1){
        alert('Please activate your account.');
    }else {
        alert('Username or Password incorrect. Please try again.');
    }
};

var LoginFunction = function(){
    var username = $("#username").val();
    var password = $("#password").val();
    var rememberme = $("#rememberme").val();
    var postData = $("#your_form_id").serializeArray();

        // do the extra stuff here
        $.ajax({
            type: "POST",
            cache: false,
            dataType: "jsonp",
            jsonp: "callback",
            async: false,
            crossDomain : true,
            url: "http://utility.findgaddi.com/helper/User/UserActionHelper.php?action=login",
            data: postData, // { password: password, username: username, rememberme: rememberme },
            jsonpCallback: function (data) { 
                if(data == null){
                    console.log("data is null");
                    return;
                }
                    alert(data);
                    console.log("logged"+data);
                    if(data == 1){
                        alert(data);
                        window.location.href = 'http://portal.findgaddi.com/';
                    }else if(data == 1){
                        alert('Please activate your account.');
                    }else {
                        alert('Username or Password incorrect. Please try again.');
                    }
                },
            success: function(data) {
                alert(data);
                console.log("logged "+data);
                if(data == 1){
                    window.location.href = 'http://portal.findgaddi.com/';
                }else if(data == 1){
                    alert('Please activate your account.');
                }else {
                    alert('Username or Password incorrect. Please try again.');
                }
            },
            error: function(XMLHttpRequest, status, error) {
            //  var err = eval("(" + xhr.responseText + ")");
                console.log("failed "+status);
                console.log("failed "+error);
              alert(error);
            }
          /*  error: function () {
                //your error code
                
                console.log("failed");
            }*/
        });

};
    
$(document).ready(function() {
  $("#login-form").submit(LoginFunction);
});

</script>
<div id="login-wrapper" class="png_bg">
			
			<div id="login-content">
				<form action="" method="POST" id="login-form">
                    <p>
						<label>Username</label>
						<input class="text-input" type="text"  name="username" id="username">
					</p>
					<div class="clear"></div>
					<p>
						<label>Password</label>
						<input class="text-input" type="password"  name="password" id="password">
					</p>
					<div class="clear"></div>
					<p id="remember-password">
						<input type="checkbox" name='rememberme' id='rememberme' value="yes" checked="checked">Remember me
					</p>
					<div class="clear"></div>
					<p>
						<input class="button" value="Sign In" type="submit">
					</p>
					<div class="clear"></div>
					<p>
						<a href="register.php" style="float:right;"> New User Register Here </a>
					</p>
					<div class="clear"></div>
					<p>
						<a href="forgetpassword.php" style="float:right;"  class="js-open-modal" href="#" data-modal-id="resetpswdpopup"> Forget Password? </a>
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  <div id="resetpswdpopup" class="modal-box" style="width:50%;">  
	  <header>
		<h3>Reset Your Password</h3>
	  </header>
	  <div class="modal-body" id="item-list">		
<!-------------------------------------------------------------------------------------------------------------------------->
						<form action="../../../utility/helper/User/UserActionHelper.php?action=resetpassword" method="POST">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								<p>
									<label>Email ID</label>
										<input class="text-input small-input" name="email_id" id="email_id" type="email" required placeholder='xyz@abc.com'> <span class="input-notification error png_bg" id="number_error"></span><span class="input-notification success png_bg" id="number_success"></span>
								</p>
								
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						
<!----------------------------------------------------------------------------------------------------------------------------->

	  <footer>
		<b><input class="button" value="SUBMIT" type="submit">&nbsp;</b>
		<a href="#" class="js-modal-close" style="color:#D3402B"><b>CANCEL</b></a>
	  </footer>
	  </form>
      </div>
</div>
<?php require_once "../../master/footerhome.php"; ?>