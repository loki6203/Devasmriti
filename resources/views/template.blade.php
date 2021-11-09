@extends('layouts.email_temp_header_footer')
@section('content')
	<p style="float:left;width:100%;text-align:left;padding:10px 0;margin:0;font-size:13px;line-height:20px;color:#333">
	Dear : <?php echo ucfirst($name);?>
	</p>
	<?php
	if($type=='signup'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		Congratulations! You are now a registered in {{ config('global.SITE_NAME') }}! ! Be sure and save the following credentials in safe location:
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Mobilenumnber: 
		<span style="font-weight:bold;"><?php echo @($mobile)?$mobile:'';?></span>
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Password: 
		<span style="font-weight:bold;"><?php echo @($pwd)?$pwd:'';?> </span>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='login'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333"></p>
		<div style="float: left; width: 100%; justify-content: center; display: flex"></div>
	<?php
	}else if($type=='chpwd'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		Success! Your Password changed successfully! Be sure and save the following credentials in safe location:
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Mobilenumnber: 
		<span style="font-weight:bold;"><?php echo @($mobile)?$mobile:'';?></span>
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Password: 
		<span style="font-weight:bold;"><?php echo @($pwd)?$pwd:'';?> </span>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='fgpwd'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		Success! Your New Password generated successfully! Be sure and save the following credentials in safe location:
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Mobilenumnber: 
		<span style="font-weight:bold;"><?php echo @($mobile)?$mobile:'';?></span>
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Password: 
		<span style="font-weight:bold;"><?php echo @($pwd)?$pwd:'';?> </span>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='tpin'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		Success! Your New Tpin generated successfully! Be sure and save the following tpin in safe location:
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Tpin: 
		<span style="font-weight:bold;"><?php echo @($tpin)?$tpin:'';?></span>
		</p>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='adhar'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		Success! Your Adhar Verified successfully!
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Adharnumber: 
		<span style="font-weight:bold;"><?php echo @($adhar)?$adhar:'';?></span>
		</p>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='pan'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		Success! Your Pannumber Verified successfully!
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">Pannumber: 
		<span style="font-weight:bold;"><?php echo @($pan)?$pan:'';?></span>
		</p>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='addmoney'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		<?php
		if($status==1){
		?>
		Success! ₹ <?php echo @($amount)?$amount:'';?> added to your account successfully!
		<?php
		}else{
		?>
		Failed! ₹ <?php echo @($amount)?$amount:'';?> adding to your account failed!
		<?php
		}
		?>
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">TransactionId: 
		<span style="font-weight:bold;"><?php echo @($transactionid)?$transactionid:'';?></span>
		</p>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='internal'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		<?php
		if($status==1){
			if($subtype==1){
			?>
				Success! ₹ <?php echo @($amount)?$amount:'';?> trnsfered to <?php echo @($benfname)?$benfname:'';?> successfully!
			<?php
			}else{
				?>
				Success! ₹ <?php echo @($amount)?$amount:'';?> recived from <?php echo @($benfname)?$benfname:'';?> successfully!
				<?php
			}
		}else{
		?>
		Failed! ₹ <?php echo @($amount)?$amount:'';?> trnsfering to <?php echo @($benfname)?$benfname:'';?> failed!
		<?php
		}
		?>
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">TransactionId: 
		<span style="font-weight:bold;"><?php echo @($transactionid)?$transactionid:'';?></span>
		</p>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='bill'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		<?php
		if($status==1){
			if($subtype==1){
			?>
				Success! ₹ <?php echo @($amount)?$amount:'';?> trnsfered to <?php echo @($benfname)?$benfname:'';?> successfully!
			<?php
			}else{
				?>
				Success! ₹ <?php echo @($amount)?$amount:'';?> recived from <?php echo @($benfname)?$benfname:'';?> successfully!
				<?php
			}
		}else{
		?>
		Failed! ₹ <?php echo @($amount)?$amount:'';?> trnsfering to <?php echo @($benfname)?$benfname:'';?> failed!
		<?php
		}
		?>
		</p>
		<p style="float:left;width:100%;text-align:left;;padding:0px 0;margin:0;font-size:13px;line-height:20px;color:#333">TransactionId: 
		<span style="font-weight:bold;"><?php echo @($transactionid)?$transactionid:'';?></span>
		</p>
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='builder'){
	?>
		<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
		Success! You added <?php $bname; ?> as builder successfully!
		</p>
		<div style="float: left; width: 100%; justify-content: center; display: flex">
		<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
		</div>
	<?php
	}else if($type=='referral'){
		?>
			<p style="float:left;width:100%;text-align:left;padding:5px 0;margin:0;font-size:13px;line-height:20px;color:#333">
			Success! Referral amount ₹ <?php echo @($amount)?$amount:'';?> added to you account successfully!
			</p>
			<div style="float: left; width: 100%; justify-content: center; display: flex">
			<a href="<?php echo url('/');?>" style="float:left;margin: 20px 0 0 0;padding:10px 20px;background:#fec627;color:#fff;font-size:14px;text-decoration:none;border-radius:3px;">Click here to Login</a>
			</div>
		<?php
	}else{

	}
	?>
@endsection