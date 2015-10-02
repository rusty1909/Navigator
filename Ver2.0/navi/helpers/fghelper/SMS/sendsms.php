<?php

function SendMessage($number, $message){
    $message = urlencode($message);
    
    $senderID = "FGaddi";
    $authkey =  '93772AqJCNg0yia560bb59a';
    $route = "4";
    
   //Prepare you post parameters
    $postData = array(
        'authkey' => $authkey,
        'mobiles' => $number,
        'message' => $message,
        'sender' => $senderID,
        'route' => $route
    );

    //API URL
    $url="http://api.msg91.com/sendhttp.php";

    // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
        //,CURLOPT_FOLLOWLOCATION => true
    ));


    //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


    //get response
    $output = curl_exec($ch);

    //Print error if any
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }

    curl_close($ch);

    echo $output;
}


if(isset($_POST) && !empty($_POST)){
    if (isset($_REQUEST['phone']) && !empty($_REQUEST['phone'])) { 
       if (isset($_REQUEST['text']) && !empty($_REQUEST['text'])) { 
           $mobile = $_REQUEST['phone'];
           $mess = $_REQUEST['text'];
           SendMessage($mobile, $mess);
       } 
       else { 
          echo "ERROR : Message not sent -- Text parameter is missing!\r\n"; 
       } 
    } 
    else { 
       echo "ERROR : Message not sent -- Phone parameter is missing!\r\n"; 
    } 
}

?>


<HTML> 
<HEAD><TITLE>Send SMS</TITLE></HEAD> 
<BODY> 
<form method="post" action="sendsms.php"> 
<table border="1"> 
<tr> 
<td>Mobile Number:</td> 
<td><input type="text" name="phone" size="40"></td> 
</tr> 
<tr> 
<td valign="top">Text Message:</td> 
<td><textarea name="text" cols="80" rows="10"></textarea> 
</tr> 
<tr> 
<td colspan="2" align="center"> 
<input type="submit" value="Send"> 
</td> 
</tr> 
</table> 
</form> 
</BODY> 
</HTML> 