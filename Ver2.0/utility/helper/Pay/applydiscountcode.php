<?php
    require_once "../../../utility/helper/Pay/PayHelper.php"; 


    if (isset($_POST['code']) && ($_POST['code'] != "")) {
        echo SNMembershipPlan::getDiscount($_POST['code']); 
    }

    exit();
?>