<?php

session_start();

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

    
    
    <!-- <?php //include("activity.php"); ?> -->
  
  
 
 
 
  </div>


  <div class="row">
    <div class="col-8 col-lg-8">

      <h3>Features</h3>


      #Account Features:

Change password
#Color

Add Vallejo colors to personal stock
Choose from all Vallejo colors on the market
#Model

Create your model project
Assign used colors to the project
Upload photos during youre project
Share project with other members

    </div>
  </div>


</div>

</body>
</html>