<?php include('Crypto.php')?>
<?php

	error_reporting(0);
	
	$workingKey='664AB39BBF9119447E372FEF436DCA7D';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$order_id = 0;
	$tracking_id='';
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
		if($i==1)	$tracking_id=$information[1];
		if($i==0)	$order_id=$information[1];
	}

	// if($order_status==="Success")
	// {
	// 	echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		
	// }
	// else if($order_status==="Aborted")
	// {
	// 	echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
	// }
	// else if($order_status==="Failure")
	// {
	// 	echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	// }
	// else
	// {
	// 	echo "<br>Security Error. Illegal access detected";
	
	// }

	// echo "<br><br>";

	// echo "<table cellspacing=4 cellpadding=4>";
	// for($i = 0; $i < $dataSize; $i++) 
	// {
	// 	$information=explode('=',$decryptValues[$i]);
	//     	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	// }

	// echo "</table><br>";
	echo "<b>Please Wait...</b>";
	echo "</center>";
	$decryptValues = json_encode($decryptValues);
?>
<form method="post" name="redirect" action="/api/ccavenue/responseHandler"> 
<?php
echo "<input type=hidden name=order_id value=$order_id>";
echo "<input type=hidden name=tracking_id value=$tracking_id>";
echo "<input type=hidden name=order_status value=$order_status>";
?>
</form>
<script language='javascript'>document.redirect.submit();</script>