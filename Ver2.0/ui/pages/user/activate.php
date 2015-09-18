
<html>
<head></head>
<body>
<?php
if(isset($_GET['q'])) {
?>
Your account has is now activated,
<br><br>
Please proceed to <a href="login.php">login page</a> to access your account.
<?php
} else {
?>
Your account has not been activated yet,
please refer to the link sent to your registered email id to activate your account.
<br><br>
<a href="login.php">Back to login page</a>
<?php
}
?>
</body></html>