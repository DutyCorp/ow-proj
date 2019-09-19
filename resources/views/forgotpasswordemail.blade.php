<!DOCTYPE html>
<html>
<head>
	<title>Reset your password</title>
	<style type="text/css">
		.smallfont {
			font-size: 8px;
		}
	</style>
</head>
<body>
	<h1>Hi, {{ $name }}</h1>
	<p>Somebody (hopefully you) has requested a new password for the OWAsia Online account for {{ $email }}</p>
	<p><a href="{{ URL::to($url) }}">Click here to enter your new password</a></p>
	<p>Regards, </p>
	<p>OWAsia Online Team</p>
	<br><br><br>
	<?php 
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('d-m-Y H:i:s.'.$micro, $t) );
	?>
	<p class="smallfont">This message was automatically generated on {{ $d->format("d-m-Y H:i:s.u") }} GMT+7</p>
</body>
</html>

