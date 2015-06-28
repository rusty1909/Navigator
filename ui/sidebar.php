<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ISSUE_2 {sidebar not updating, means its not highlighting the current page.}
// START [
$url = explode("/", $_SERVER['REQUEST_URI']); 
//echo "-----------------------------------------------------------------------------------------------------------------------------";
//print_r($url);
// ] END

//github


require_once "../../framework/Company.php";
$mIsCompanyRegistered =  Company::isCompanyRegistered($mUser->getCompany());

if($mIsCompanyRegistered){
	$mCompany = new Company($mUser->getCompany());
}else{
	$mCompany = null;
}

?>
		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title"><a href="#">FindGaddi</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="../../res/logo.png" alt="FindGaddi logo"></a>
		  
			<!-- Sidebar Profile links -->
			<?php
            
			if(isset($_SESSION['user'])) {
				//header('Location')
			?>
			<div id="profile-links">
				Hello, <a href="/navigator/ui/setting/" title="Edit your profile"><?php echo $mUser->getFullName(); ?></a><br>
				<?php if($mIsCompanyRegistered && $mCompany->getName() !="") echo "<a href='/navigator/ui/company/'>".$mCompany->getName()."<a><br>";
					else {
						echo '<a href="/navigator/ui/company/register.php">&ltClick to Register Your Company&gt</a><br>';
					}
				?>
				<br>
				<!--<a href="#" title="View the Site">View the Site</a> | --><a href="/navigator/ui/user/action.php?action=logout" title="Sign Out">Sign Out</a>
			</div>        
			<br><br>
			<ul id="main-nav">  <!-- Accordion Menu -->
				
				<li>
					<a href="/navigator/ui/user/" class="nav-top-item no-submenu <?php if($url[3] == 'user') echo 'current'; ?>"> <!-- Add the class "no-submenu" to menu items with no sub menu -->
						Dashboard
					</a> 					
				</li>
				
				<li> 
					<a href="#" class="nav-top-item <?php if($url[3] == 'vehicle') echo 'current'; ?>"> <!-- Add the class "current" to current menu item -->
					Vehicles
					</a>
					<ul style="display: block;">
						<li><a class="<?php if(($url[3] == 'vehicle') && ($url[4] == '' || $url[4] == 'index.php' || $url[4] == 'edit.php' || explode("?", $url[4])[0] == 'detail.php')) echo 'current'; ?>" href="/navigator/ui/vehicle/">Manage Vehicles</a></li>
						<!--<li><a href="#">Servicing Details</a></li>-->
					</ul>
				</li>
				
				<li>
					<a href="#" class="nav-top-item <?php if($url[3] == 'driver') echo 'current'; ?>">
						Drivers
					</a>
					<ul style="display: none;">
						<li><a href="/navigator/ui/driver/">Manage Drivers</a></li>
						<!--<li><a href="#">Previous Drivers</a></li>-->
					</ul>
				</li>  
				
<!--				<li>
					<a href="#" class="nav-top-item <?php if($url[3] == 'setting') echo 'current'; ?>">
						Settings
					</a>
					<ul style="display: none;">
						<li><a class="<?php if(($url[3] == 'setting') && ($url[4] == '' || $url[4] == 'index.php')) echo 'current'; ?>" href="/navigator/ui/setting/">Your Profile</a></li>
						<li><a href="#">Manage Staff</a></li>
					</ul>
				</li>     -->
				
				<li>
					<a href="#" class="nav-top-item">
						Issues
					</a>
					<ul style="display: none;">
						<li><a href="/navigator/admin/issue/"  target="_admin">Issue List</a></li>
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
						<li><a href="https://play.google.com/store/apps/details?id=com.navigator.trackapp " target="_blank"> FindGaddi Android APP </a></li>
					</ul>
				</li>
							
			</ul> <!-- End #main-nav -->
			<?php
			}
			?>
			
			<div id="messages" style="display: none"> <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->
				
				<h3>3 Messages</h3>
			 
				<p>
					<strong>17th May 2009</strong> by Admin<br>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
			 
				<p>
					<strong>2nd May 2009</strong> by Jane Doe<br>
					Ut a est eget ligula molestie gravida. Curabitur massa. Donec 
eleifend, libero at sagittis mollis, tellus est malesuada tellus, at 
luctus turpis elit sit amet quam. Vivamus pretium ornare est.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
			 
				<p>
					<strong>25th April 2009</strong> by Admin<br>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
					<small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
				</p>
				
				<form action="" method="post">
					
					<h4>New Message</h4>
					
					<fieldset>
						<textarea class="textarea" name="textfield" cols="79" rows="5"></textarea>
					</fieldset>
					
					<fieldset>
					
						<select name="dropdown" class="small-input">
							<option selected="selected" value="option1">Send to...</option>
							<option value="option2">Everyone</option>
							<option value="option3">Admin</option>
							<option value="option4">Jane Doe</option>
						</select>
						
						<input class="button" value="Send" type="submit">
						
					</fieldset>
					
				</form>
				
			</div> <!-- End #messages -->
			
		</div></div> <!-- End #sidebar -->