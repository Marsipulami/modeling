<?php

session_start();
// var_dump($_SESSION);


?>

<?php

  include("includes/header.inc.php");

 
  include_once("includes/sessioncheck.inc.php");

  include("includes/menu.inc.php");

    if($_SESSION['role'] !== "1"){
        die('<div class="alert alert-danger">Onvoldoende rechten.</div>');
    }



    $qry = $db_link->prepare("SELECT * FROM logging ORDER By timestamp DESC ");
    $qry->execute();
    $brands = null;
    while($row = $qry->fetch()) {
        echo $row['timestamp'] .  " " .  $row['logvalue'] . "<br />";
    }    

?>
