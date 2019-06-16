<?php

session_start();
// var_dump($_SESSION);


?>
<!DOCTYPE html>
<html lang="en">

<?php

  include("includes/header.inc.php");
  include("includes/addPhoto.inc.php");

 
  include_once("includes/sessioncheck.inc.php");

  include("includes/menu.inc.php");

    // if($_SESSION['role'] !== "super_admin"){
    //     die('<div class="alert alert-danger">Onvoldoende rechten.</div>');
    // }


    if(isset($_POST['submitmodel'])){



        // var_dump($_POST);
        // var_dump($_FILES);

       
        
        $addmodel = true;
        $modelid = $_POST['modelid'];
        if($modelid == "NULL"){
            try{
            $qry = $db_link->prepare("INSERT INTO models (models_id, models_brand, name, scale, prodnumber) 
                        VALUES (NULL, :brandid, :name, :scale, :prodnumber)");
            $qry->execute(array(':brandid'=>$_POST['mbrand'], 
                                    ':name'=>$_POST['mname'],
                                    ':prodnumber'=>$_POST['mnumber'],
                                        ':scale'=>$_POST['scale']));

            echo '<div class="alert alert-success">Model toegevoegd aan de database.</div>';
            Log::addLogEntry($db_link, $_SESSION['usersid'], "User ".$_SESSION['username'] . " added Model to Stock");
            $modelid = $db_link->lastInsertId();
            }catch(Exception $e){
                echo '<div class="alert alert-danger">Model toevoegen mislukt.</div>';
                $addmodel = false;
            }
        }
      

        if($addmodel){

            try{
                        $qry = $db_link->prepare("INSERT INTO users_models (um_id, model_date,user_id, model_id) 
                                    VALUES (NULL, :modelDate, :userid, :modelid)");
                        $qry->execute(array(':userid'=>$_SESSION['usersid'], 
                                            ':modelDate'=>time(),
                                                ':modelid'=>$modelid));
            
                        echo '<div class="alert alert-success">Model toegevoegd aan je profiel</div>';
                        
                        $umid = $db_link->lastInsertId();


                        try{
                            $photoupload = new Photo($_FILES,$umid,$db_link);
                            echo '<div class="alert alert-success">Foto upload geslaagd.</div>';
                        }catch(Exception $e){
                            
                            echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
                            
                        }
                        




                }catch(Exception $e){
                    echo $e->getMessage();
                    echo '<div class="alert alert-danger">Model toevoegen mislukt.</div>';
                    
                }



        }

       
        // var_dump($_POST);
    }





?>



<body>

<?

echo "test";
    $qry = $db_link->prepare("SELECT brand,brands.id,models.name,models_id,scale,prodnumber FROM models,brands WHERE models.models_brand=brands.id");
    $qry->execute();

    $pre_loadedmodels = null;
    while($row = $qry->fetch()) {
        $pre_loadedmodels[] = array("id"=>$row['models_id'], "name"=>$row['name'], "brandid"=>$row['id']
                                                                                    , "brand"=>$row['brand']
                                                                                    , "prodnumber"=>$row['prodnumber']
                                                                                    , "scale"=>$row['scale']);
   }

   var_dump($pre_loadedmodels);


   $qry = $db_link->prepare("SELECT brand,brands.id FROM brands,brands_types,brand_types WHERE brands_types.brands_id=brands.id
    AND brands_types.types_id=brand_types.id 
        AND brand_types.id=1");
    $qry->execute();
    $brands = null;
    while($row = $qry->fetch()) {
        $brands[$row['id']] = $row['brand'];
    }   



   
   echo '<script>

   $(document).ready(function() {

   var objects = '.json_encode((array)$pre_loadedmodels) . ';

   var $input = $(".typeahead");
        $input.typeahead({
        source: objects,
        autoSelect: true
        });
        $input.change(function() {
        var current = $input.typeahead("getActive");
        if (current) {
            // Some item from your model is active!
            if (current.name == $input.val()) {
                $(\'#mbrand\').val(current.brandid)                
                $(\'#mnumber\').val(current.prodnumber)                
                $(\'#scale\').val(current.scale)                
                $(\'#modelid\').val(current.id)                



            } else {
                $(\'#modelid\').val("NULL")     
            }
        } else {
            
        }
        });
    });
   
   
   
   
   
   
   
   
   
    </script>
   
   ';
?>

<div class="container">

    <form method="post" action="" enctype="multipart/form-data" >

        <div class="row">
            <div class="col-sm-4 col-lg-12">
             <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <input type="text"  name="mname" class="form-control typeahead" data-provide="typeahead" required/>
                        <input type="hidden"  name="modelid" id="modelid" value="NULL"/>
                    </div>
                </div>
                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <select name="mbrand" id="mbrand" class="custom-select" required>
                            <option value="" selected>Merk</option>
                            <?php
                                foreach($brands as $k=>$brand){
                                    echo '<option value="'.$k.'">'.$brand.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <select name="scale" id="scale" class="custom-select" required>
                            <option value="" selected>Schaal</option>
                            <option value="Niet bekend" >Niet bekend</option>
                            <option value="1:16" >1:16</option>
                            <option value="1:35" >1:35</option>
                            <option value="1:48" >1:48</option>
                            <option value="1:72" >1:72</option>
                            <option value="1:144" >1:144</option>
                            
                        </select>
                    </div>
                </div>
               
                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <input type="text" placeholder="Product number" name="mnumber" id="mnumber" class="form-control input-lg"/>
                    </div>
                </div>

            

                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                    <input type="file" name="image" accept="image/*" >
                    </div>
                </div>

                
                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-4">
                        <input type="submit" name="submitmodel" class="input-lg" value="Toevoegen" />
                    </div>
                </div>
               
               
            </div>
        </div>




    </form>


</div>








</body>
</html>