<?php
include_once("../utils/SNMembershipPlan.php");

if(!empty($_POST["planID"])) {
    
    $id = $_POST["planID"];
    $prod = new SNMembershipPlan($id);
    
    $x =  $prod->getJson();
    
    echo $x;
    exit();
}
?>