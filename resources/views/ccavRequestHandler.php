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

