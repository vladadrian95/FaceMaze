<!DOCTYPE html> 
<html lang = "en">
 
   <head> 
      <meta charset = "utf-8"> 
      <title>FaceMaze</title> 
   </head> 
	
   <body>
      <form action="<?php echo 'http://localhost/FaceMaze/index.php/Main_Controller/logout'; ?>">
         <button type="submit">Logout</button>
      </form>
      <?php
         echo "User's high score is ";
         echo $high_score;
         echo '<br>';
         echo "User's last score is ";
         echo $last_score;
         echo '<br>';
      ?>
   </body>
	
</html>