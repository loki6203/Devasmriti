<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>
<center>

<?php include('Crypto.php')?>
<?php 

	error_reporting(0);
	
	$merchant_data='';
	$working_key='664AB39BBF9119447E372FEF436DCA7D';//Shared by CCAVENUES
	$access_code='AVHN05KJ30CF33NHFC';//Shared by CCAVENUES
	
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
?>
<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
<!-- <input type="submit"/> -->
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

