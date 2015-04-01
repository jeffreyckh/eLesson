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
	<link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
	
</head>

<div class="container">
	<div class="row">
		<div class="fourcol"></div>
		<div class="twocol">
			<fieldset>
				<legend class="loginlegend">Reset Passwords</legend>
				<?php $register->resetPassword(); ?>
					<div class="threecol">
						<form method="post" action="forget_passwords.php" id="login_form">
							<div class="row loginrow">
								<p><label class="loginbox" for="Email">Email:</label><input class="text" type="text" name="Email" /></p>
							</div>
							<div class="row loginrow">
								<div class="twocol last">
									<input class="submit" type="submit" value="SUBMIT" name="Reset"/>
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
