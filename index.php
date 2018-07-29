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
    <br /><br />
      <h3>Features</h3>


      #Account Features: <br />
      <br />
Change password<br />
#Color<br />
<br />
Add Vallejo colors to personal stock<br />
Choose from all Vallejo colors on the market<br />
#Model<br />
<br />
Create your model project<br />
Assign used colors to the project<br />
Upload photos during youre project<br />
Share project with other members<br />
<br />

    </div>
  </div>


</div>

</body>
</html>