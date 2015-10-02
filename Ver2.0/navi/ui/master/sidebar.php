<?php
$url = explode("/", $_SERVER['REQUEST_URI']); 

$mIsCompanyRegistered =  Company::isCompanyRegistered($mUser->getCompany());

if($mIsCompanyRegistered){
	$mCompany = new Company($mUser->getCompany());
}else{
	$mCompany = null;
}

?>
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="http://www.findgaddi.com/">FindGaddi</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a target='_blank' href='http://web.findgaddi.com'><img id="logo" src="http://images.findgaddi.com/logo.png" alt="FindGaddi logo"></a>
		  
			<!-- Sidebar Profile links -->
			<?php
            
			if(isset($_SESSION['user'])) {
				//header('Location')
			?>
			<div id="profile-links">
				Hello, <a href="http://www.findgaddi.com/navigator/Ver2.0/ui/pages/setting/" title="Edit your profile"><?php echo $mUser->getFullName(); ?></a><br>
				<?php if($mIsCompanyRegistered && $mCompany->getName() !="") echo "<a href='http://www.findgaddi.com/navigator/Ver2.0/ui/pages/company/'>".$mCompany->getName()."<a><br>";
					else {
						echo '<a href="http://www.findgaddi.com/navigator/Ver2.0/ui/pages/company/register.php">&ltClick to Register Your Company&gt</a><br>';
					}
				?>
				<br>
				<!--<a href="#" title="View the Site">View the Site</a> | --><a href="http://www.findgaddi.com/navigator/Ver2.0/utility/helper/User/UserActionHelper.php?action=logout" title="Sign Out">Sign Out</a>
			</div>        
			<br><br>
			<ul id="main-nav">  <!-- Accordion Menu -->
				
				<li>
					<a href="http://www.findgaddi.com/navigator/Ver2.0/ui/pages/user/" class="nav-top-item no-submenu <?php if($url[3] == 'user') echo 'current'; ?>"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
						Dashboard
					</a> 					
				</li>
				
				<li> 
					<a href="#" class="nav-top-item <?php if($url[3] == 'vehicle') echo 'current'; ?>"> <!-- Add the class "current" to current menu item -->
					Vehicles
					</a>
					<ul style="display: block;">
						<li><a class="<?php if(($url[3] == 'vehicle') && ($url[4] == '' || $url[4] == 'index.php' || $url[4] == 'edit.php' || explode("?", $url[4])[0] == 'detail.php')) echo 'current'; ?>" href="http://www.findgaddi.com/navigator/Ver2.0/ui/pages/vehicle/">Manage Vehicles</a></li>
					</ul>
				</li>
				
				<li>
					<a href="#" class="nav-top-item <?php if($url[3] == 'driver') echo 'current'; ?>"> Drivers </a>
					<ul style="display: none;">
						<li><a href="http://www.findgaddi.com/navigator/Ver2.0/ui/pages/driver/">Manage Drivers</a></li>
					</ul>
				</li>  
			<?php 
			if($mUser->getUsername() == "rusty" || $mUser->getUsername() == "dheerajagrawal19@live.com" || $mUser->getUsername() == "sumshri") {
			?>
				<li>
					<a href="#" class="nav-top-item">
						Admin
					</a>
					<ul style="display: none;">
						<li><a href="/navigator/admin/userlist.php"  target="_admin">User List</a></li>
					</ul>
				</li> 
			<?php } ?>
				
				<li>
					<a href="#" class="nav-top-item">
						Download App
					</a>
					<ul style="display: none;">
						<li><a href="https://play.google.com/store/apps/details?id=com.findgaddi.tracker" target="_blank"> findGaddi Tracker App </a></li>
					</ul>
				</li>
							
			</ul> <!-- End #main-nav -->
			<?php 			} 			?>
			
			
			
		</div></div> <!-- End #sidebar -->