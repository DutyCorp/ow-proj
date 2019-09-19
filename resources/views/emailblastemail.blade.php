<!DOCTYPE html>
<html>
<head>
	<title>Email Blast</title>
	<style type="text/css">
		body {
		    font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
		    font-size: 10pt;
		}
		.smallfont {
			font-size: 8pt;
		}
		.centered {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="container">
		<p>Dear {{ $EmployeeName }}, </p>
		<p>{!! $BodyEmail !!}</p>
		<br><br><br>
		<?php 
			$t = microtime(true);
			$micro = sprintf("%06d",($t - floor($t)) * 1000000);
			$d = new DateTime( date('d-m-Y H:i:s.'.$micro, $t) );
		?>
		<p class="smallfont">P.S. Please do not reply this email.</p>
		<p class="smallfont">This message was automatically generated on {{ $d->format("d-m-Y H:i:s.u") }} GMT+7</p>
	</div>
</body>
</html>