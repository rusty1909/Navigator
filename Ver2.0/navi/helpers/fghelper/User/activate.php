<html>
<head></head>
<body>
<?php
if(isset($_GET['q'])) {
?>
Your account has is now activated,
<br><br>
Please proceed to <a href="http://www.findgaddi.com/navigator/Ver2.0/ui/pages/user/login.php">login page</a> to access your account.
<?php
} else {
?>
Your account has not been activated yet,
please refer to the link sent to your registered email id to activate your account.
<br><br>
<a href="http://www.findgaddi.com/navigator/Ver2.0/ui/pages/user/login.php">Back to login page</a>
<?php
}
?>
</body></html>