<html>
<head>
<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
	};
</script>
</head>
<body>
<b>Please wait....</b>
<form method="post" name="customerData" action="/cc/ccavRequestHandler.php">
<input type="hidden" name="tid" id="tid" readonly /></td>
<input type="hidden" name="merchant_id" value="<?php echo @$respdata['merchant_id'];?>"/></td>
<input type="hidden" name="order_id" value="<?php echo @$respdata['order_id'];?>"/></td>
<input type="hidden" name="amount" value="<?php echo @$respdata['amount'];?>"/></td>
<input type="hidden" name="currency" value="<?php echo @$respdata['currency'];?>"/></td>
<input type="hidden" name="redirect_url" value="<?php echo @$respdata['redirect_url'];?>"/></td>
<input type="hidden" name="cancel_url" value="<?php echo @$respdata['cancel_url'];?>"/></td>
<input type="hidden" name="language" value="<?php echo @$respdata['language'];?>"/></td>
<input type="hidden" name="billing_name" value="<?php echo @$respdata['billing_name'];?>"/></td>
<input type="hidden" name="billing_address" value="<?php echo @$respdata['billing_address'];?>"/></td>
<input type="hidden" name="billing_city" value="<?php echo @$respdata['billing_city'];?>"/></td>
<input type="hidden" name="billing_state" value="<?php echo @$respdata['billing_state'];?>"/></td>
<input type="hidden" name="billing_zip" value="<?php echo @$respdata['billing_zip'];?>"/></td>
<input type="hidden" name="billing_country" value="<?php echo @$respdata['billing_country'];?>"/></td>
<input type="hidden" name="billing_tel" value="<?php echo @$respdata['billing_tel'];?>"/></td>
<input type="hidden" name="billing_email" value="<?php echo @$respdata['billing_email'];?>"/></td>
<input type="hidden" name="delivery_name" value="<?php echo @$respdata['delivery_name'];?>"/></td>
<input type="hidden" name="delivery_address" value="<?php echo @$respdata['delivery_address'];?>"/></td>
<input type="hidden" name="delivery_city" value="<?php echo @$respdata['delivery_city'];?>"/></td>
<input type="hidden" name="delivery_state" value="<?php echo @$respdata['delivery_state'];?>"/></td>
<input type="hidden" name="delivery_zip" value="<?php echo @$respdata['delivery_zip'];?>"/></td>
<input type="hidden" name="delivery_country" value="<?php echo @$respdata['delivery_country'];?>"/></td>
<input type="hidden" name="delivery_tel" value="<?php echo @$respdata['delivery_tel'];?>"/></td>
<input type="hidden" name="merchant_param1" value="<?php echo @$respdata['merchant_param1'];?>"/></td>
<input type="hidden" name="merchant_param2" value="<?php echo @$respdata['merchant_param2'];?>"/></td>
<input type="hidden" name="merchant_param3" value="<?php echo @$respdata['merchant_param3'];?>"/></td>
<input type="hidden" name="merchant_param4" value="<?php echo @$respdata['merchant_param4'];?>"/></td>
<input type="hidden" name="merchant_param5" value="<?php echo @$respdata['merchant_param5'];?>"/></td>
<input type="hidden" name="promo_code" value="<?php echo @$respdata['promo_code'];?>"/></td>
<input type="hidden" name="customer_identifier" value="<?php echo @$respdata['customer_identifier'];?>"/>
</form>
</body>
<script language='javascript'>document.customerData.submit();</script>
</html>