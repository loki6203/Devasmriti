<html>
<head>
<title> Devasmriti </title>
</head>
<body>
<center>
<?php 
if($isValid>0){
	error_reporting(0);
	$merchant_data='';
	foreach ($respdata as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
	$merchant_data='tid=1698760911917&merchant_id=2742697&order_id=123654522&amount=1.00¤cy=INR&redirect_url=https://api-backend.devasmriti.com/ccavenue/responseHandler&cancel_url=https://api-backend.devasmriti.com/ccavenue/responseHandler&language=EN&billing_name=Charli&billing_address=Room no 1101, near Railway station Ambad&billing_city=Indore&billing_state=MP&billing_zip=425001&billing_country=India&billing_tel=9876543210&billing_email=test@test.com&delivery_name=Chaplin&delivery_address=room no.701 near bus stand&delivery_city=Hyderabad&delivery_state=Andhra&delivery_zip=425001&delivery_country=India&delivery_tel=9876543210&merchant_param1=additional Info.&merchant_param2=additional Info.&merchant_param3=additional Info.&merchant_param4=additional Info.&merchant_param5=additional Info.&promo_code=&customer_identifier=&';
	echo $merchant_data;
	echo '<hr>';
	echo $access_code;
	echo '<hr>';
	echo $working_key;
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
}else{
	
}
?>
<form method="post" name="redirect" action="<?php echo $ccurl;?>"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
<input type="submit"/>
</form>
</center>
<!-- <script language='javascript'>document.redirect.submit();</script> -->
</body>
</html>

