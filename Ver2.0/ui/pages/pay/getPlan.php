<?php
require_once "../../framework/PaymentHelper.php";

if(!empty($_POST["planID"])) {
    
    $id = $_POST["planID"];
    
    echo  (new PaymentHelper())->getJson($id);
    
    exit();
}
?>