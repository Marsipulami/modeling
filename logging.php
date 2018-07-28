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

    echo '<div class="container">';
                    echo '<div class="row top-buffer">';
                        echo '<div class="col-12">';
                                    

    while($row = $qry->fetch()) {
        echo '<div class="row">';
            echo '<div class="col-12">';
                echo $row['timestamp'] .  " " .  $row['logvalue'] . "<br />";
            echo '</div>';
        echo '</div>';
    }    

            echo '</div>';
        echo '</div>';
    echo '</div>';

?>
