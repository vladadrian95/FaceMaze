<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>

<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<title>FazeMaze</title>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu" />
	<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css"> 
	<script type="text/javascript">
		function toggleContent(id) {
			if (id == "registerForm") {
				var contentId = document.getElementById("registerForm"); 
				contentId.style.display = "block";
				var contentId = document.getElementById("loginForm");
				contentId.style.display = "none";
				document.getElementById("registerM").className = "sim-button button1Active";
      			document.getElementById("loginM").className = "sim-button button1";
			} else {
				var contentId = document.getElementById("loginForm"); 
				contentId.style.display = "block";
				var contentId = document.getElementById("registerForm");
				contentId.style.display = "none";
				document.getElementById("loginM").className = "sim-button button1Active";
      			document.getElementById("registerM").className = "sim-button button1";
			}
		}
	</script>
</head>
<body>
    <!-- Before login --> 
	<div class="centered">
		<div id="loginM" class="sim-button button1Active">
			<a href="javascript:toggleContent('loginForm');"><span>Login</span></a> 
		</div>
		<span class"clear"></span>
		<div id="registerM" class="sim-button button1">
			<a href="javascript:toggleContent('registerForm');"><span>Register</span></a> 
		</div>
		<span class"clear"></span>
		
		<form id="loginForm" name="loginForm" class="customForm" role="form" action="<?php echo 'http://localhost/FaceMaze/index.php/Main_Controller/login'; ?>" method="post" style="display:block;">
			<div>
				<input type="email" id="email" name="email" placeholder="Email Address">
				<input type="password" id="password" name="password" placeholder="Password">
			</div>
			<div id="facebookLogin" class="sim-button button1">
				<a href="fbconfig.php"><span>Facebook</span></a> 
			</div>
			<span class"clear"></span>
			<div id="twitterLogin" class="sim-button button1">
				<a href="process.php"><span>Twitter</span></a> 
			</div>
			<span class"clear"></span>
			<div id="submitButton" class="sim-button button1">
				<a href="javascript:document.loginForm.submit();"><span>Sign-in</span></a> 
			</div>

		</form>
		<form id="registerForm" name="registerForm" class="customForm" action="<?php echo 'http://localhost/FaceMaze/index.php/Main_Controller/register'; ?>" method="post" style="display:none;">
			<div>
				<input type="text" id="register_user" name="register_user" placeholder="Username">
				<input type="text" id="register_email" name="register_email" placeholder="E-mail">
				<input type="password" id="pass" name="pass" placeholder="Password">
				<input type="password" id="confirmpwd" name="confirmpwd" placeholder="Confirm Password">
			</div>
			<div id="submitButton" class="sim-button button1">
				<a href="javascript:document.registerForm.submit();"><span>Sign-up</span></a> 
			</div>
			
		</form>
	</div>
</body>
</html>