<?php
	require_once '../framework/Vehicle.php';
    require_once '../framework/Company.php';

	//print_r($_POST);
	if(isset($_GET['tin'])) {
		$tin = trim($_GET['tin']);
		//if($tin != "") {
		$companyId = Company::getIdByTin($tin);
		$mCompany = new Company($companyId);
		$mList = $mCompany->getWaitingVehicleList();
		//echo "hello";
		//print_r($mList);
		echo json_encode($mList);			
		//}
	} else {
		if(isset($_GET['vehicle']) && isset($_GET['type'])) {
            $setup = array();
			$vehicle = trim($_GET['vehicle']);	
            $type = trim($_GET['type']);
			$vehicleId = Vehicle::getIdByNumber($vehicle);
            $setup['setup']['model'] = "";
            $setup['setup']['type'] = "";
            $setup['setup']['number'] = "";
            $setup['setup']['company_name'] = "";
            $setup['setup']['owner'] = "";
            $setup['setup']['contact'] = "";
            if($vehicleId==null) {
                $setup['setup']['result']="fail_vehicle";
            } else{
                $mVehicle = new Vehicle($vehicleId);
                if($mVehicle->getType()!=$type){
                    $setup['setup']['result']="fail_type";
                    //echo "fail_type";
                } else{
                    if($mVehicle->isDeployed()==1){
                        $setup['setup']['result']="already";
                        //echo "already";
                    } else {
                        if($mVehicle->deploy()) {
                            $setup['setup']['result']="success";
                            $companyId = $mVehicle->getCompany();
                            $setup['setup']['model'] = $mVehicle->getModel();
                            $setup['setup']['type'] = $mVehicle->getType();
                            $setup['setup']['number'] = $mVehicle->getVehicleNumber();
                            $mCompany = new Company($companyId);
                            $setup['setup']['company_name'] = $mCompany->getName();
                            $setup['setup']['owner'] = $mCompany->getAdmin();
                            $setup['setup']['contact'] = $mCompany->getPhone();
                            //echo "success";
                        }
                        else {
                            $setup['setup']['result']="fail";
                            //echo "fail";
                        }
                    }
                    
                }

                
            }
            echo json_encode($setup);
		}
	}

?>