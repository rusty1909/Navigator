<?php
error_reporting(E_ALL);
ini_set('display_errors',1);


//Company Details...
define ("WEB_FULL_NAME", "FindGaddi.com"); // set database host
define ("WEBSITE_NAME", "www.findgaddi.com"); // set database host
define ("WEB_MAIL_ID", "info@findgaddi.com"); // set database host
define ("WEB_MAIL_REPLY_ID", "info@findgaddi.com"); // set database host
define ("WEB_MAIL_ACTIVATION_ID", "activate@findgaddi.com"); // set database host

$headers  = "From: FindGaddi<".WEB_MAIL_REPLY_ID.">\r\n";
$activation_headers = "From: FindGaddi<".WEB_MAIL_ACTIVATION_ID.">\r\n";

$sheaders = "Reply-To: FindGaddi<".WEB_MAIL_REPLY_ID.">\r\n";
$sheaders .= "MIME-Version: 1.0\n";
$sheaders .= "Content-type: text/html; charset=utf-8\n";

$headers .= $sheaders;
$activation_headers .= $sheaders;


define ("Def_headers", $headers); // set database host
define ("activation_headers", $activation_headers); // set database host

class Mailer {
	
	public static function sendActivationMail($id){
		$securityKey = Security::getSecurityKey($id);
		
		$message = "Click the following link to activate your FindGaddi.com account. www.findgaddi.com/navigator/ui/user/action.php?action=activate&id=".$id."&key=".$securityKey;
		
		mail($email, 'Navigator Activation mail', $message);
	}

    public static function makeMessage($msg){

        $message =  '<table cellpadding="10"><tbody><tr><td align="center" style="padding:30px"><a href="http://www.findgaddi.com/" target="_blank"><img src="http://www.findgaddi.com/navigator/res/logo_small.png" alt="FindGaddi" style="width: 40px; border-radius: 10%;"></a> </td><td width="90%" style=background: #3b5998; color: #ffffff;"> <h2>FindGaddi.com</h2> </td> </tr> <tr> <td align="center" > </td> <td>';

        $message .= $msg;
        $message .= "<b><br /><br />Best Regards, <br /> FindGaddi.com Team<br /></b>";
        $message .= '<h5 style=font-size: 16px; text-transform: uppercase; margin-bottom: 20px; font-family: Verdana,Geneva,sans-serif; font-weight: normal; line-height: 2em; padding-left: 15px; color: #FFF;">Find us on <span>Social Networks</span></h5>
        <ul style="margin: 0px; padding: 0px; list-style: outside none none;">
        <li style="display: inline-block; margin-left: 5px;"><a href="https://www.facebook.com/findgaddi" target="_blank"><img src="http://www.findgaddi.com/navigator/res/facebook.png" alt="FindGaddi on facebook" style="width: 30px; border-radius: 10%;"></a></li>
        <li style="display: inline-block; margin-left: 5px;"><a href="https://twitter.com/findgaddi" target="_blank"><img src="http://www.findgaddi.com/navigator/res/twitter.png" alt="FindGaddi on twitter" style="width: 30px; border-radius: 10%;"> </a></li>
        <li style="display: inline-block; margin-left: 5px;"><a href="https://in.linkedin.com/in/findgaddi" target="_blank"><img src="http://www.findgaddi.com/navigator/res/linkedin.png" alt="FindGaddi on linkedin" style="width: 30px; border-radius: 10%;"></a></li>
        <li style="display: inline-block; margin-left: 5px;"><a href="https://www.youtube.com/channel/UCXvvEkFKX3_mZsZG3e_ebfw" target="_blank"><img src="http://www.findgaddi.com/navigator/res/youtube.png" alt="FindGaddi on youtube" style="width: 30px; border-radius: 10%;"></a></li>
        <li style="display: inline-block; margin-left: 5px;"><a href="https://plus.google.com/+findgaddi" target="_blank"><img src="http://www.findgaddi.com/navigator/res/google.png" alt="FindGaddi on google" style="width: 30px; border-radius: 10%;"></a></li>
        </ul>';

        $message .=  '</td></tr></tbody></table>';
        return $message;
    }
        
    public static function addMessageFooter($puserid){
        $message =  '<table width="100%" cellpadding="30"><tbody><tr><td align="left" style="padding:30px">
                   This message was sent to <a href="mailto:'.$puserid.'" style="color:#3b5998;text-decoration:none;font-size:12px;line-height:16px" target="_blank">'.$puserid.'</a>. If you do not want to receive these emails from findgaddi in the future,<br /> please <a href="http://www.findgaddi.com/unsubscribe.php?id='.$puserid.'" style="color:#3b5998;text-decoration:none;font-size:12px;line-height:16px" target="_blank">unsubscribe</a>. © 2015 findgaddi. New Delhi, India</td>
            </tr>
            </tbody>
        </table>';

        return $message;
    }

    public static function sendActivationMessage($pfullname, $pusername, $pemail,$securityKey){
        $msgToUser = "";
        $subject = 'Complete Your ' . WEB_FULL_NAME . ' Registeration';
        $message = "Dear ".strtoupper($pfullname).",<br /><br />

            You have successfully created account with .<br />
            Account Details :<br /><br />
            Name : $pfullname<br />
            UserName : $pusername<br />
            Email ID: $pemail<br /><br /><br />
            Complete this step to activate your account at ".WEB_FULL_NAME."<br />

            Click the line below to activate when ready<br />
            http://".WEBSITE_NAME."/navigator/ui/user/action.php?action=activate&email=$pemail&key=$securityKey<br /><br /><br />
            If the URL above is not an active link, please copy and paste it into your browser address bar

            Login after successful activation using your:  <br /><br />";

            $message = Mailer::makeMessage($message); 

           if(mail($pemail, $subject, $message, activation_headers)) {
               $msgToUser = "<h2>One Last Step - Activate through Email</h2><h4>$pfullname, there is one last step to verify your email identity:</h4><br />
               In a moment you will be sent an Activation link to your email address.<br /><br />
               <br />	   ";
           }else {		
            //second case if email link is not working.....	
                 $msgToUser = "<h2>$pfullname,<span> you have successfully registered with us.</span></h2><br />
                                Please <a href='./index.php'>Login</a>...<br /><br />";
            }

            return $msgToUser;
    }

    public static function sendEmployeeAddedMessage($pfullname, $pusername, $pemail, $password){
        $msgToUser = "";
        $subject = 'You have been added as Employee For ' . WEB_FULL_NAME ;
        $message = "Dear ".strtoupper($pfullname).",<br /><br />

            You have successfully created account with .<br />
            Account Details :<br /><br />
            Name : $pfullname<br />
            UserName : $pusername<br />
            Email ID: $pemail<br /><br /><br />
            Password: $password<br /><br /><br />
            Complete this step to activate your account at ".WEB_FULL_NAME."<br />";

          $message .= "Please change your password as soon as possible."; 
            
            $message = Mailer::makeMessage($message); 

           if(mail($pemail, $subject, $message, activation_headers)) {
               $msgToUser = "<h2>One Last Step - Activate through Email</h2><h4>$pfullname, there is one last step to verify your email identity:</h4><br />
               In a moment you will be sent an Activation link to your email address.<br /><br />
               <br />	   ";
           }else {		
            //second case if email link is not working.....	
                 $msgToUser = "<h2>$pfullname,<span> you have successfully registered with us.</span></h2><br />
                                Please <a href='./index.php'>Login</a>...<br /><br />";
            }

            return $msgToUser;
    }

    public static function SendMessagebyPHP($puserid,$subject,$message ){
        $msgToUser = "";

        $msg = "Dear ".$puserid;
        $msg  .= "<br /><br />";


        $message = $msg.$message;

        $message = Mailer::makeMessage($message); 

        $message .= Mailer::addMessageFooter($puserid);

        if(mail($puserid, $subject, $message, Def_headers)) {
               $msgToUser = "We will revert you soon, please stay tuned...";
           }else {		
                 $msgToUser ="There was some error, please try again...";
            }
        return $msgToUser;
    }

    public static function SendMessageResettoME($puserid){
        $msgToUser = "";

        $message = "Dear ".$puserid;
        $message  .= "<br /><br />";
        $message .= "Complete this step to reset your account passsword at ".WEB_FULL_NAME."<br />

        Click the line below to activate when ready<br />

        http://".WEBSITE_NAME."/resetpassword.php?id=$puserid<br /><br /><br />
        If the URL above is not an active link, please copy and paste it into your browser address bar

        Please Login after successful reset using your password:  <br /><br />
        E-mail Address: $puserid <br />

        See you on the site!<br /><br />";

    $message = Mailer::makeMessage($message); 

        if(mail($puserid, "Please Reset your password at ".WEB_FULL_NAME, $message, Def_headers)) {
            $msgToUser = "<h2>One Last Step - Reset through Email</h2><h4>$puserid, there is one last step to reset your email identity:</h4><br />
           In a moment you will be sent an Reset link to your email address.<br /><br />
           <br />
           ";
        }else {		
        $msgToUser = "Some Technical Faults...";
        }

        return $msgToUser;

    }
    
    public static function SendResetPasswd($puserid,$subject,$message ){
        $msgToUser = "";

        $msg = "Dear Customer,";
        $msg  .= "<br /><br />";


        $message = $msg.$message;

        $message = Mailer::makeMessage($message); 

       if(mail($puserid, $subject, $message, Def_headers)) {
               $msgToUser = "We will revert you soon, please stay tuned...";
           }else {	
                return false;
                 $msgToUser ="There was some error, please try again...";
            }
        return $msgToUser;
    }

    public static function SendReActivationMessage($pfullname,$puserid,$ppasswdHash ){
    $msgToUser = "";
    $subject = 'Complete Your ' . WEB_FULL_NAME . ' Registration';

        $message = "Dear ".$puserid;
        $message  .= "<br /><br />";
        $message = "Complete this step to activate your account at ".WEB_FULL_NAME."<br />

        Click the line below to activate when ready<br />

        http://".WEBSITE_NAME."/activation.php?id=$puserid&sequence=$ppasswdHash<br /><br /><br />
        If the URL above is not an active link, please copy and paste it into your browser address bar

        Login after successful activation using your:  <br /><br />
        E-mail Address: $puserid <br />

        See you on the site!<br /><br />";

    $message = Mailer::makeMessage($message); 

       if(mail($puserid, $subject, $message, Def_headers)) {
           $msgToUser = "<h2>One Last Step - Re Activate through Email</h2><h4>$pfullname, there is one last step to verify your email identity:</h4><br />
           In a moment you will receive an Activation link to your email address.<br /><br />
           <br />	   ";
       }else{
            $msgToUser = "<h3>There was some technical fault, please try again...</h3>";
       }

        return $msgToUser;
    }

    //payment mails...
    public static function SendPaymentNotifcation($pfullname, $pemail, $amount, $pass){

        $msg = "Dear $pfullname";
        if($pass)
            $msg .= "Congrats, You have successfully made transaction of $amount .";
        else
            $msg .= "Unfortunately, Transaction of $amount was not successful.";
        
        if($pass)
            Mailer::SendPaymentSuccessMessage($pemail, $msg);
        else
            Mailer::SendPaymentFailureMessage($pemail, $msg);
        
    }
    
    public static function SendPaymentSuccessMessage($puserid,$message ){
        $msgToUser = "";
        $message = makeMessage($message); 
       if(mail($puserid, "Payment was successful...", $message, Def_headers)) {
           $msgToUser = "Payment was successful...
           ";
       }else {		
             $msgToUser = "Some Technical Faults...";
        }

        return $msgToUser;
    }

    public static function SendPaymentFailureMessage($puserid,$message ){
        $msgToUser = "";
        $message = makeMessage($message); 
       if(mail($puserid, "There was a transaction failure.", $message, Def_headers)) {
           $msgToUser = "There was a transaction failure.";
       }else {		
        $msgToUser = "Some Technical Faults...";
        }

        return $msgToUser;
    }
    
}

//echo Mailer::SendResetPasswd('dheerajagrawal19@gmail.com', 'dheerajagrawal19@gmail.com', 'dheerajagrawal19@gmail.com');
?>