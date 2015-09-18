<?php
include_once("../utils/SNMembershipPlan.php");


if (isset($_POST['code']) && ($_POST['code'] != "")) {
    echo SNMembershipPlan::getDiscount($_POST['code']); 
}
  
exit();
?>