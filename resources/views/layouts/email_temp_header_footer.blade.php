<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{{ config('global.SITE_NAME') }}</title>
    <style>
        .interests-btns{
            float: left;
            width: 100%;
            margin: 10px 0;
        }
        .interests-btns a{
            float: left;
            width: auto;
            text-decoration: none;
            background: #faa026;
            border-radius: 6px;
            border: 1px solid #f7a126;
            padding: 8px 30px;
            text-transform: uppercase;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
            margin-right: 10px;
        }
        .interests-btns a{
            background: #fff;
            border: 1px solid #f7a126;
            color: #faa026;
        }
    </style>
</head>
<body style="margin:0px;padding:0px;background:#f8fafc;font-family:sans-serif">
<div style="float:left;width:100%;padding-left:18%;">
	<div style="float:left;width:60%;background:#fff;margin:0 auto;border:2px solid #fff1ca;margin-top:30px;padding:10px 20px 40px 20px">
		<div style="  float: left;width: 100%;border-bottom: 2px solid #fff1ca;padding: 0 0 5px 0;">
			<h1 style="float:left;width:60%;padding:0;margin:0;text-align:left;font-size:16px;line-height: 50px;">&nbsp;</h1>
			<div style="float:left;width:40%;">
				<img style="float:right;width:150px; margin-top: 5px" src="<?php echo url('/');?>/logo.png"/>
			</div>
		</div>
		<div style="float:left;width:100%;margin-top:20px;">
			@yield('content')
			<p>&nbsp;</p>
			<p style="float:left;width:100%;text-align:left;padding:10px 0;margin:0;font-size:13px;line-height:20px;color:#333">Be sure and contact us if you have questions or experience technical difficulties.</p>
			<span style="float:left;width:100%;text-align:left;padding:30px 0 0 0;margin:0;font-size:13px;line-height:20px;color:#333;">Thank you,</span>
			<h2 style="float:left;width:100%;text-align:left;padding:0px 0 0 0;margin:0;font-size:13px;line-height:20px;color:#333;font-weight:normal;font-weight:bold;">{{ config('global.SITE_NAME') }} Team</h2>
		</div>
	</div>
</div>
</body>
</html>
