<?php
if(!isset($mUser)) {
	require_once '/navigator/framework/User.php';
	$mUser = new User();
}

//prateek

$companyId = $mUser->getCompany();
if($companyId == 0) {
	header('Location:/navigator/ui/company/register.php');
}
?>


<a href="/navigator/ui/user/">DASHBOARD</a>
<?php
if($companyId != -1) {
?>
<a href="/navigator/ui/job/">JOBS</a>
<a href="/navigator/ui/order/">ORDERS</a>
<a href="/navigator/ui/vehicle/">VEHICLES</a>
<a href="/navigator/ui/driver/">DRIVERS</a>
<a href="/navigator/ui/client/">CLIENTS</a>
<?php
}
?>
<div style="float:right">
<?php
	echo $mUser->getUserName()."    ( ".$mUser->getCompany()." )";
?>
<a href="/navigator/ui/user/action.php?action=logout" target="_top">Logout</a>
<a href="/navigator/ui/user/setting/" target="_top">Settings</a>
</div>
<hr>
