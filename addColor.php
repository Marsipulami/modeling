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


    if(isset($_POST['submit'])){

        try{
            $qry = $db_link->prepare("INSERT INTO paintdatabase.colors (color_id, brands_id, types_id, color_name, color_code) 
                                        VALUES (NULL, :brand, :type, :name, :code)");
            $qry->execute(array(':brand'=>$_POST['brand'],
                                ':type'=>$_POST['type'],
                                ':name'=>$_POST['colorname'],
                                ':code'=>$_POST['colorcode']));

            echo '<div class="alert alert-success">Kleur toegevoegd aan de database.</div>';
        }catch(Exception $e){
            echo '<div class="alert alert-warning">Kleur bestaat al.</div>';
        }
        // var_dump($_POST);
    }





?>



<body>

<?php

$qry = $db_link->prepare("SELECT brand,brands.id FROM brands,brands_types,brand_types WHERE brands_types.brands_id=brands.id
AND brands_types.types_id=brand_types.id 
    AND brand_types.id=2");
$qry->execute();
$brands = null;
while($row = $qry->fetch()) {
    $brands[$row['id']] = $row['brand'];
}    


// var_dump($brands);
$qry = $db_link->prepare("SELECT * FROM types");
$qry->execute();
$types = null;
while($row = $qry->fetch()) {
    $types[$row['id']] = $row['type'];
}    


?>

<div class="container">

    <form method="post" action="" >

        <div class="row">
            <div class="col-sm-4 col-lg-12">
                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <select name="brand" class="custom-select" required>
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
                        <select  name="type"  class="custom-select" required>
                            <option  value="" selected>Type</option>
                            <?php
                                foreach($types as $k=>$type){
                                    echo '<option value="'.$k.'">'.$type.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <input type="text" placeholder="ColorName" name="colorname" class="form-control input-lg" required/>
                    </div>
                </div>

                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-8">
                        <input type="text" placeholder="ColorCode" name="colorcode" class="form-control input-lg" required />
                    </div>
                </div>

                <div class="row top-buffer">
                    <div class="col-sm-4 col-lg-4">
                        <input type="submit" name="submit" class="input-lg" value="Toevoegen" />
                    </div>
                </div>
               
               
            </div>
        </div>




    </form>


</div>








</body>
</html>