<?php
if(!isset($_SESSION)) session_start();
include_once("includes/sessioncheck.inc.php");
include_once("includes/addPhoto.inc.php");



    if(defined('INC_TEST')){
        echo '<div class="row buffer" >';
        echo '<div class="col-12">';
            echo '<h3>Modellen</h3>';
        echo '</div>';
        echo '</div>';


       $qry = $db_link->prepare("SELECT brand,imagepath,name,users_models.um_id FROM users_models,models,brands WHERE models.models_brand=brands.id 
                                                                                        AND users_models.model_id = models_id 
                                                                                         
                                                                                          AND users_models.user_id= :userID");
       $qry->execute(array(':userID'=>$_SESSION['usersid']));


       if($qry->rowCount() == 0){

          echo "Nog geen modellen ingevoerd";

       }
      // echo '<pre>';
       while($row = $qry->fetch()) {
        echo '<a href="models.php?used_model='.$row['um_id'].'" >
        <div class="row buffer" id="model_row">';
            echo '<div class="col-2">';
                echo '<img class="logo_small" src="'.$row['imagepath'].'" />';
            echo '</div>';
            echo '<div class="d-none d-md-block col-md-4 col-lg-3">';
                echo $row['brand'];
            echo '</div>';
            echo '<div class="col-10">';
                echo $row['name'];
            echo '</div>';

           

        
        
        echo '</div></a>';  

       }

    }else{

        include_once("includes/header.inc.php");
        include_once("includes/menu.inc.php");


        ?>
        <script>
                $(function() {

                    // We can attach the `fileselect` event to all file inputs on the page
                    $(document).on('change', ':file', function() {
                    var input = $(this),
                        numFiles = input.get(0).files ? input.get(0).files.length : 1,
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [numFiles, label]);
                    });

                    // We can watch for our custom `fileselect` event like this
                    $(document).ready( function() {
                        $(':file').on('fileselect', function(event, numFiles, label) {

                            var input = $(this).parents('.input-group').find(':text'),
                                log = numFiles > 1 ? numFiles + ' files selected' : label;

                            if( input.length ) {
                                input.val(log);
                            } else {
                                if( log ) alert(log);
                            }

                        });








                      






                    });

                    $('.img-wrap .close').on('click', function() {
                        var id = $(this).closest('.img-wrap').find('img').data('id');
                        // alert('remove picture: ' + id);
                        var urlParams = new URLSearchParams(window.location.search);
                        var r = confirm("Zeker weten dat je deze wilt verwijderen ? ")
                        if(r == true){
                            window.location.href = location.protocol + '//' + location.host + location.pathname + '?used_model='+ urlParams.get('used_model') + '&deleteImage=true&imageToBeDeleted='+id ;
                        }
                        
                    });



                });
        </script>
        <?php
        if(isset($_POST['submitPhoto']) && $_GET['action'] == "uploadfile"){


            try{
                $photoupload = new Photo($_FILES,$_GET['used_model'],$db_link);
                echo '<div class="alert alert-success tempalert">Foto upload geslaagd.</div>';
            }catch(Exception $e){
                
                echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
                
            }
        }

        if(isset($_GET['used_model']) && isset($_GET['addColor'])){

            try{
                $qry = $db_link->prepare("INSERT INTO users_models_colors (umc_id, um_id,paints_id,comment) VALUES 
                                                                                                    (NULL, :umid, :paintid, :comment)");
                $qry->execute(array(':comment'=>$_POST['beschrijving'], 
                                    ':paintid'=>$_POST['color'],
                                    ':umid'=>$_GET['used_model']));
                                   
                echo '<div class="alert alert-success tempalert">Kleur bijgevoegd aan model</div>';
            }catch(Exeception $e)    {
                echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
            }
           

        }


        if(isset($_GET['used_model']) && isset($_GET['editcomments']) && isset($_POST['comments'])){
           
            try{
                $qry = $db_link->prepare("UPDATE paintdatabase.users_models SET comments= :comments WHERE users_models.user_id = :userID AND um_id= :umid");
                $qry->execute(array(':comments'=>$_POST['comments'], 
                                    ':userID'=>$_SESSION['usersid'],
                                    ':umid'=>$_GET['used_model']));
                                   
                echo '<div class="alert alert-success tempalert">Comments bijgewerkt.</div>';
            }catch(Exeception $e)    {
                echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
            }
        }

        if(isset($_GET['used_model']) && isset($_GET['deleteImage']) && isset($_GET['imageToBeDeleted'])){

            $image_qry = $db_link->prepare("SELECT image_path,umg_id FROM users_models,users_models_images WHERE users_models.um_id = users_models_images.um_id
                                                                                        
            AND users_models.user_id= :userID
            AND users_models_images.um_id = users_models.um_id
            AND users_models_images.umg_id= :umgID");
            $image_qry->execute(array(':userID'=>$_SESSION['usersid'],':umgID'=>$_GET['imageToBeDeleted']));

            $row = $image_qry->fetch();
            if (file_exists($row['image_path'])) {
                unlink($row['image_path']);
                $image_qry = $db_link->prepare("DELETE FROM users_models_images WHERE umg_id = :umgID");

                $image_qry->execute(array(':umgID'=>$_GET['imageToBeDeleted']));
                echo '<div class="alert alert-success tempalert">Foto verwijderd.</div>';
            }else{
                echo '<div class="alert alert-danger">Er is iets fout gegaan bij het verwijderen.</div>';
            }
            
        }


        if(isset($_GET['used_model']) && isset($_GET['deleteColor'])){

            $image_qry = $db_link->prepare("SELECT umc_id FROM users_models_colors,users_models WHERE 
            users_models.um_id = users_models_colors.um_id
                                                                                        
            AND users_models.user_id= :userID
            AND users_models.um_id = :umID
            AND users_models_colors.umc_id= :umcID");
            $image_qry->execute(array(':userID'=>$_SESSION['usersid'],':umID'=>$_GET['used_model'],':umcID'=>$_GET['deleteColor']));

            $row = $image_qry->fetch();
            if($row !== false){
                try{                
                $delete = $db_link->prepare("DELETE FROM users_models_colors WHERE umc_id = :umcID");
                $delete->execute(array(':umcID'=>$row['umc_id']));
                echo '<div class="alert alert-success tempalert">Kleur bij model verwijderd</div>';
                }catch(Exeception $e)    {
                    echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
                }
            }
            
            
        }

        echo '<div class="container">';

        if(!isset($_GET['used_model'])){
            echo '<div class="alert alert-danger">Geen model geselecteerd.</div>';
            die();
        }else{
            // echo '<pre>';
            try{
                $qry = $db_link->prepare("SELECT comments,brand,model_date,prodnumber,scale,name,users_models.um_id FROM users_models,models,brands WHERE models.models_brand=brands.id 
                                                                                            AND users_models.model_id = models_id 
                                                                                        
                                                                                            AND users_models.user_id= :userID
                                                                                                AND users_models.um_id= :umID");
                $qry->execute(array(':userID'=>$_SESSION['usersid'],':umID'=>$_GET['used_model']));
                if($qry->rowCount() == 0) throw new Exception("Er zijn geen resultaten gevonden");
            }catch(Exception $e){
                echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
                die();
            }
            while($row = $qry->fetch()) {

                echo '<div class="row">';
                
                    echo '<div class="col-12">';
                        echo '<span ><h3>'.$row['brand']. " " . $row['name'] .'</h3></span>';
                    echo '</div>';
                    
                echo '</div>';   
                echo '<div class="row top-buffer">';
                    echo '<div class="col-6">';
                        echo '<strong>Schaalgrootte: </strong>'.$row['scale'];
                    echo '</div>';
                    echo '<div class="col-6">';
                        echo '<strong>Toegevoegd: </strong>'.date("d-m-Y",$row['model_date']);
                    echo '</div>';
                echo '</div>';
                echo '<div class="row">';
                    echo '<div class="col-12">';
                        echo '<strong>Productnummer: </strong>'.$row['prodnumber'];
                    echo '</div>';
                echo '</div>';


                echo '<div class="row top-buffer">';

                    echo '<div class="col-12">';
                    echo '<form method="post" action="models.php?used_model='.$_GET['used_model'].'&editcomments=true">';
                        echo '<div class="row">';
                
                            echo '<div class="col-12">';
                                echo '<div class="form-group">
                                    
                                    <textarea class="form-control" name="comments" rows="5" id="comment" >'.$row['comments'].'</textarea>
                                </div>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="row">';
                            echo '<div class="col-12">';    
                                echo '<button type="submit" class="btn btn-primary btn-sm">Opslaan</button>';
                            echo '</div>';
                        echo '</div>';
                    echo '</form>';
                    echo '</div>';
                echo '</div>';

                

                echo '<div class="row top-buffer">';

                    echo '<div class="col-12">';
                    echo '<form method="post" action="models.php?used_model='.$_GET['used_model'].'&addColor=true">';
                        echo '<div class="row">';
                
                            echo '<div class="col-12">';
                               
                                echo '<h4>Gebruikte kleuren</h4>';
                                echo '<br />';
                                $qry = $db_link->prepare("SELECT umc_id,users_models_colors.comment,users_models.um_id,imagepath,color_id,color_name,rgb,brand FROM users_models,users_models_colors,colors,brands WHERE 
                                                                                                users_models_colors.um_id=users_models.um_id
                                                                                            AND users_models_colors.paints_id=colors.color_id
                                                                                            AND colors.brands_id=brands.id
                                                                                            AND users_models.user_id= :userID
                                                                                                AND users_models.um_id= :umID");
                                $qry->execute(array(':userID'=>$_SESSION['usersid'],':umID'=>$_GET['used_model']));
                                if($qry->rowCount() > 0){
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
                                            echo '<div class="col-3 col-md-3 col-lg-2">';
                                                echo $row['color_name'];
                                            echo '</div>';
                                            echo '<div class="col-4 col-lg-4">';
                                                echo $row['comment'];
                                            echo '</div>';
                                            echo '<div class="col-1 col-lg-1">';
                                                echo '<span style="border:1px solid black; background-color: #'.$row['rgb'].'" >&nbsp;&nbsp;&nbsp;&nbsp; </span>';
                                            echo '</div>';
                                            echo '<div class="col-1 col-lg-1">';
                                                echo '<button type="button" class="close" aria-label="Close">
                                                <a href="models.php?used_model='.$row['um_id'].'&deleteColor='.$row['umc_id'].'" ><span aria-hidden="true">&times;</span></a>
                                            </button>';
                                            echo '</div>';
                                        
                                        
                                        echo '</div>';  
                                
                                    }
                                }else{
                                    echo '<div class="alert alert-info">Nog geen kleuren toegevoegd aan dit model.</div>';
                                }
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="row">';
                            echo '<div class="col-12">';    
                               

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

                            echo '<div class="row top-buffer"><div class="col-sm-4 col-lg-4">
                                    <input type="text" class="colorobject-multiple form-control"  name="color"  required/>    
                                </div>
                                <div class="col-sm-4 col-lg-4">
                                 <input type="text" class="form-control"  name="beschrijving" placeholder="Waar gebruikt"  required/>    
                                </div>
                                <div class="col-sm-4 col-lg-4">
                                 <input type="submit" class="btn btn-primary btn-sm"  name="submitColor" value="Voeg kleur toe" />    
                                </div></div>';












                            echo '</div>';
                        echo '</div>';
                    echo '</form>';
                    echo '</div>';
                echo '</div>';






                $image_qry = $db_link->prepare("SELECT image_path,umg_id,upload_date FROM users_models,users_models_images WHERE users_models.um_id = users_models_images.um_id
                                                                                        
                                                                                            AND users_models.user_id= :userID
                                                                                                AND users_models.um_id= :umID");
                $image_qry->execute(array(':userID'=>$_SESSION['usersid'],':umID'=>$_GET['used_model']));
                echo '<div class="row top-buffer">';
                if($image_qry->rowCount() == 0){
                    //geen images
                }else{
                    
                    while($imagerow = $image_qry->fetch()) {
                        
                            echo '<div class="col">';
                                echo '<div class="row">';
                                    echo '<div class="col">';
                                   
                                        echo '<div class="img-wrap">';
                                            echo '<span class="close">&times;</span>';
                                            
                                            echo '<a href="'.$imagerow['image_path'] .'" data-lightbox="roadtrip"><img class="show_case "  src='.$imagerow['image_path'] .' data-id="'.$imagerow['umg_id'].'" /></a>';
                                           
                                        echo '</div>';
                                       
                                    echo '</div>';
                                echo '</div>';  
                                echo '<div class="row">';
                                    echo '<div class="col">';
                                        echo '<span>'.date("d-m-Y",$imagerow['upload_date']) .'</span>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                            
                        

                    }
                    
                    
                }
                             
                echo '</div>';
                echo '<div class="row top-buffer">';
                echo '<div class="col">';
                                echo '<form method="post" action="models.php?used_model='.$_GET['used_model'].'&action=uploadfile" enctype="multipart/form-data" >';
                                
                               
                                   echo '<div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            Browse&hellip; <input   type="file" name="image" style="display: none;" accept="image/*"  >
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" readonly>
                                    </div> ';
                                   
                                    
                                    echo '<input type="submit" class="buffer btn btn-primary btn-sm" name="submitPhoto" class="input-lg" value="Foto uploaden" />';

                                echo '</form>';
                            echo '</div>';
                echo '</div>';
                // var_dump($row);

            }

        }

        echo '</div>';

        


    }
    ?>