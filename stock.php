<?php
if(!isset($_SESSION)) session_start();
include_once("includes/sessioncheck.inc.php");

echo '<div class="row buffer" >';
echo '<div class="col-12">';
    echo '<h3>Verf voorraad</h3>';
echo '</div>';
echo '</div>';

       $qry = $db_link->prepare("SELECT imagepath,rgb,brand,color_name,color_code,type,airbrush,stock FROM users_colors,brands,colors,types WHERE users_colors.color_id=colors.color_id AND colors.brands_id = brands.id AND colors.types_id=types.id AND users_colors.users_id= :userID ORDER BY color_code");
       $qry->execute(array(':userID'=>$_SESSION['usersid']));


       if($qry->rowCount() == 0){

          echo "Nog geen verf voorraad ingevoerd";

       }
      // echo '<pre>';

       $maxShown = 5;
       $count = 0;
       $entries = $qry->rowCount();
       while($count < 5 && $row = $qry->fetch()) {

        $count++;
        echo '<div class="row " >';
            echo '<div class="col-2 col-lg-1">';
                echo '<img src="'.$row['imagepath'].'" class="logo_small" />';;
            echo '</div>';
            echo '<div class="d-none d-md-block col-md-4 col-lg-1">';
                echo $row['brand'];
            echo '</div>';
            echo '<div class="d-none d-md-block col-md-6 col-lg-2">';
                echo $row['type'];
            echo '</div>';
            echo '<div class="col-6 col-md-6 col-lg-2">';
                echo $row['color_name'];
            echo '</div>';
            echo '<div class="col-1 col-lg-1">';
                echo $row['stock'];
            echo '</div>';
            echo '<div class="col-1 col-lg-1">';
                echo '<span style="border:1px solid black; background-color: #'.$row['rgb'].'" >&nbsp;&nbsp;&nbsp;&nbsp; </span>';
            echo '</div>';
            echo '<div class="col-1 col-lg-1">';
                echo $row['color_code'];
            echo '</div>';
        
        
        echo '</div>';  

       }

       if($entries > 5){
        

        echo '<div id="stock" class="collapse">';

        while($row = $qry->fetch()) {

            
            echo '<div class="row " >';
                echo '<div class="col-2 col-lg-1">';
                    echo '<img src="'.$row['imagepath'].'" class="logo_small" />';;
                echo '</div>';
                echo '<div class="d-none d-md-block col-md-4 col-lg-1">';
                    echo $row['brand'];
                echo '</div>';
                echo '<div class="d-none d-md-block col-md-6 col-lg-2">';
                    echo $row['type'];
                echo '</div>';
                echo '<div class="col-6 col-md-6 col-lg-2">';
                    echo $row['color_name'];
                echo '</div>';
                echo '<div class="col-1 col-lg-1">';
                    echo $row['stock'];
                echo '</div>';
                echo '<div class="col-1 col-lg-1">';
                    echo '<span style="border:1px solid black; background-color: #'.$row['rgb'].'" >&nbsp;&nbsp;&nbsp;&nbsp; </span>';
                echo '</div>';
                echo '<div class="col-1 col-lg-1">';
                    echo $row['color_code'];
                echo '</div>';
            
            
            echo '</div>';  
    
           }
        echo '</div>';
        echo '<button data-toggle="collapse" class="btn btn-primary btn-sm" data-target="#stock">Laat meer zien</button>';

       }


    ?>