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
	// $merchant_data='merchant_id=2742697&order_id=1234&currency=INR&amount=1.00&redirect_url=https%3A%2F%2Fapi-backend.devasmriti.com%2Fccavenue%2FresponseHandler&cancel_url=https%3A%2F%2Fapi-backend.devasmriti.com%2Fccavenue%2FresponseHandler&language=EN&billing_name=Peter&billing_address=Santacruz&billing_city=Mumbai&billing_state=MH&billing_zip=400054&billing_country=India&billing_tel=9876543210&billing_email=testing%40domain.com&delivery_name=Sam&delivery_address=Vile+Parle&delivery_city=Mumbai&delivery_state=Maharashtra&delivery_zip=400038&delivery_country=India&delivery_tel=0123456789&merchant_param1=additional+Info.&merchant_param2=additional+Info.&merchant_param3=additional+Info.&merchant_param4=additional+Info.&merchant_param5=additional+Info.&promo_code=&customer_identifier=';
	// echo $merchant_data;
	// echo '<hr>';
	// echo $working_key;
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

