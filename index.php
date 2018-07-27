<?php

session_start();
// var_dump($_SESSION);



?>


<?php

  include("includes/header.inc.php");
  include_once("includes/sessioncheck.inc.php");
?>


<body>

<?php
include("includes/menu.inc.php");
?>

<div class="container">
  



 
  <div class="row">
    <div class="col-8 col-lg-8">
    
      <?php include("stock.php"); ?>
    
    
    </div>
    <div class="col-8 col-lg-4">
    
      <?php define('INC_TEST', "boe"); include("models.php"); ?>
    
    
    </div>
 
 
  </div>

</div>

</body>
</html>