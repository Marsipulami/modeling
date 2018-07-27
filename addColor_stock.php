<?php

session_start();
// var_dump($_SESSION);


?>
<!DOCTYPE html>
<html lang="en">

<?php

  include("includes/header.inc.php");

 
  include_once("includes/sessioncheck.inc.php");

  include("includes/menu.inc.php");

    // if($_SESSION['role'] !== "super_admin"){
    //     die('<div class="alert alert-danger">Onvoldoende rechten.</div>');
    // }


    if(isset($_POST['submit'])){

        $qry = $db_link->prepare("SELECT paints_id,stock FROM users_colors,brands,colors,types WHERE users_colors.color_id=colors.color_id AND colors.brands_id = brands.id AND colors.types_id=types.id AND users_colors.users_id= :userID AND users_colors.color_id= :colorID");
        $qry->execute(array(':userID'=>$_SESSION['usersid'], 
                                ':colorID'=>$_POST['color']));

        if($qry->rowCount() > 0){
          //Update
            $current = $qry->fetchObject();
            $newstock= ($current->stock+$_POST['number']);
           
            $qry = $db_link->prepare("UPDATE paintdatabase.users_colors SET stock= :stock WHERE users_colors.paints_id= :paintID");
            $qry->execute(array(':stock'=>$newstock, 
                                ':paintID'=>$current->paints_id));

            echo '<div class="alert alert-success">Kleur toegevoegd aan reeds bestaande voorraad.</div>';
        }else{
            //insert

            $qry = $db_link->prepare("INSERT INTO paintdatabase.users_colors (paints_id, users_id, color_id, stock) 
                        VALUES (NULL, :userID, :colorID, :stock)");
            $qry->execute(array(':userID'=>$_SESSION['usersid'], 
                                    ':colorID'=>$_POST['color'],
                                        ':stock'=>$_POST['number']));

            echo '<div class="alert alert-success">Kleur toegevoegd aan persoonlijke voorraad.</div>';
        }
        
       
        // var_dump($_POST);
    }





?>



<body>

<?php

$qry = $db_link->prepare("SELECT color_id,color_name,color_code,brand,type FROM brands,types,colors WHERE colors.brands_id=brands.id AND colors.types_id=types.id");
$qry->execute();
// echo '<pre>';
$available_colors = null;
while($color = $qry->fetch()) {
    $available_colors[] = array("id"=>$color['color_id'], "text"=>$color['brand']." ".$color['type']." ".$color['color_name']." ".$color['color_code']);
    
}

echo '
			
<script>
var colors = '.json_encode((array)$available_colors) . ';
$(document).ready(function() {
							
   
       
        $(".colorobject-multiple").select2({
            data: colors
        });

});


</script>';
?>

<div class="container">

    <form method="post" action="" >

        <div class="row">
            <div class="col-sm-4 col-lg-12">
                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <input type="text" class="colorobject-multiple form-control"  name="color" placeholder="blaat" required/>    
                    </div>
                </div>

                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <input type="number" class="form-control" value="1" name="number" required/>    
                    </div>
                </div>

                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                    <input type="file" name="image" accept="image/*">
                    </div>
                </div>

                
                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-4">
                        <input type="submit" name="submit" class="input-lg" />
                    </div>
                </div>
               
               
            </div>
        </div>




    </form>


</div>








</body>
</html>