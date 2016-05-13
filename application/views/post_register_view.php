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
	<form id="gotoForm" class="customForm" action="<?php echo 'http://localhost/FaceMaze/index.php/Main_Controller/index'; ?>">
        <button id="gotoBttn" class="backBttn" type="submit">Go to login page</button>
    </form>
	<div class="centered">
	<?php
	    echo "<br>";
        echo $status_message;
      ?>
	</div>
</body>
</html>