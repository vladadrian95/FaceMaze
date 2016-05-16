<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<title>FaceMaze</title>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu" />
	<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
</head>
<body>
	<div class="centered">
	<div class="status_msg">
		<?php echo "<br>"; echo $status_message;?>
	</div>

	<span class"clear"></span>
	<form id="gotoForm" class="customForm" action="<?php echo 'http://localhost/FaceMaze/index.php/Main_Controller/index'; ?>">
		<div id="submitButton" class="sim-button button1">
				<a href="javascript:document.gotoForm.submit();"><span>Back to login page</span></a> 
		</div>
    </form>
	</div>
</body>
</html>