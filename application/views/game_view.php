<!DOCTYPE html> 
<head> 
   <meta charset = "utf-8"> 
   <title>FaceMaze</title> 
   <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu" />
   <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/game_style.css">
</head> 
<body>
   <div class="right">
      <p class="high_score_text" id="best_score"></p>
      <p class="last_score_text" id="last_score"></p>
      <form class="form_style" action="<?php echo 'http://localhost/FaceMaze/index.php/Main_Controller/logout'; ?>">
         <button class="logout_button" type="submit">Logout</button>
      </form>
   </div>
   <span>
      <script src="<?php echo base_url(); ?>js/resources.js"></script>
      <!--<script src="<?php echo base_url(); ?>js/app.js"></script>-->
      <script src="<?php echo base_url(); ?>js/engine.js"></script>
   </span>
</body>
	
</html>