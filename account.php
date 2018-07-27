<?php
if(!isset($_SESSION)) session_start();
include_once("includes/sessioncheck.inc.php");



        include_once("includes/header.inc.php");
        include_once("includes/menu.inc.php");


        ?>
       
        <?php



//        $Qry = $db_link->prepare("SELECT * FROM users WHERE users_name = :User AND users_password = :Pass");


        if(isset($_POST['save'])){

            // var_dump($_POST);

            if(isset($_POST['username']) && $_POST['username'] !== ""){
                    // echo 'username change</br>';

            $qry = $db_link->prepare("UPDATE users SET users_name= :username WHERE users_id= :userid");
            $res = $qry->execute(array(':username'=>$_POST['username'], 
                                ':userid'=>$_SESSION['usersid']));

            if($res){
                echo '<div class="alert alert-success">Gebruikersnaam aangepast.</div>';
                $_SESSION['username'] = htmlentities($_POST['username']);
            }

            }
            if(isset($_POST['pass1']) && isset($_POST['pass2']) && $_POST['pass1'] !== "" && $_POST['pass2'] !== ""){
                // echo 'password change';

                if($_POST['pass1'] !== $_POST['pass2']){
                           echo ('<div class="alert alert-danger">Opgegeven wachtwoorden niet gelijk.</div>');

                }else{

                $qry = $db_link->prepare("UPDATE users SET users_password= :passwordhash WHERE users_id= :userid");
                 $res = $qry->execute(array(':passwordhash'=>hash('sha256',$_POST['pass1']), 
                                ':userid'=>$_SESSION['usersid']));

                                if($res){
                                    echo '<div class="alert alert-success">Wachtwoord aangepast.</div>';
                                }
                }
            }
        }
        




        
            echo '<form method="post" action="" >';
            
                                
            echo '<div class="container">';
                    echo '<div class="row top-buffer">';
                        echo '<div class="col-12">';
                                    echo '<div class="row">';
                                    
                                        echo '<div class="col-sm-4 col-lg-8">';
                                        echo '<label for="username">Username wijzigen: </label> <div class="form-group"><input type="text" id="username" class="form-control"  name="username" placeholder="'.$_SESSION['username'].'" /> </div>  '; 
                                        echo ' </div>';

                                    echo '</div>';
                                    echo '<div class="row">';
                                    
                                        echo '<div class="col-sm-4 col-lg-8">';
                                        echo ' <label for="pass1">Nieuw wachtwoord: </label> <div class="form-group"><input type="password" id="pass1" class="form-control"  name="pass1" placeholder="Wachtwoord" />  </div> '; 
                                        echo ' </div>';

                                    echo '</div>';
                                    echo '<div class="row">';
                                        
                                        echo '<div class="col-sm-4 col-lg-8">';
                                        echo ' <label for="pass2">Herhaal wachtwoord: </label> <div class="form-group"><input type="password" id="pass2"  class="form-control"  name="pass2" placeholder="Herhaling wachtwoord" />  </div>'; 
                                        echo ' </div>';

                                    echo '</div>';

                                    echo '<div class="row">';
                                        
                                        echo '<div class="col-sm-4 col-lg-8">';
                                        echo ' <input type="submit" name="save" value="Wijzigen" />   '; 
                                        echo ' </div>';

                                    echo '</div>';
                        echo '</div>';
                    echo '</div>';
            echo '</div>';

            echo '</form>';
                    // var_dump($row);

      

        

        

    ?>