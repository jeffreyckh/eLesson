<?php 
include 'inc/header.php'; 
session_start();
require_once('view/RegistrationView.php');
require_once('inc/db_config.php');

$register = new RegistrationView();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The 1140px Grid - http://cssgrid.net/ -->
	<link rel="stylesheet" href="jscss/1140.css" type="text/css" media="screen" />
	
	<!-- Your styles -->
	<link rel="stylesheet" href="jscss/styles.css" type="text/css" media="screen" />
	
</head>

<div class="container">
	<div class="row">
		<div class="fourcol"></div>
		<div class="twocol">
			<fieldset>
				<legend class="loginlegend">Login</legend>
				<?php $register->validateLoginData(); ?>
					<div class="threecol">
						<form method="post" action="login.php" id="login_form">
							<div class="row loginrow">
								<p><label class="loginbox" for="Username">User ID:</label><input class="text" type="text" name="Username" /></p>
							</div>
							<div class="row loginrow">
								<p><label class="loginbox" for="Password">Password:</label><input class="text" type="password" name="Password" /></p>
							</div>
							<div class="row loginrow">
								<div class="threecol">
									<a href="lostPassword.php" class="loginbox">Forgot your password?</a> <br />
									<a href="registration.php" class="loginbox">Register</a>
								</div>
								<div class="twocol last">
									<input class="submit" type="submit" value="SUBMIT" name="Login"/>
								</div>
							</div>
						</form>
					</div>
			</fieldset>
		</div>
	</div>
</div>

</body>

</html>
