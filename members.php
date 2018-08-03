<?php
if(!isset($_SESSION)) session_start();


        include_once("includes/sessioncheck.inc.php");
        include_once("includes/header.inc.php");
        include_once("includes/menu.inc.php");
        include_once("includes/email.inc.php");


        ?>
<script>
        $(document).ready(function () {
             $('#membertable').DataTable();
             $('.dataTables_length').addClass('bs-select');
        });

</script>
       
        <?php

        if($_SESSION['role'] !== "1"){
            die('<div class="alert alert-danger">Onvoldoende rechten.</div>');
        }





        if(isset($_GET['deleteUser'])){
        


            //Na bevestiging
            //Modellen verwijderen
                //Fotos bij modellen verwijderen, disk + db
                //Gebruikers kleuren verwijderen
                //Kleuren bij gebruikermodellen verwijderen

            echo "User verwijderen";
            

        }
        
           if(isset($_POST['add_user'])){

            
            try{
                $qry = $db_link->prepare("INSERT INTO users (users_id,users_name,users_password,email,role,last_login) VALUES 
                                                                                                    (NULL,:users_name, :users_password, :email, 0,0)");

                

                $passHash = substr(md5(time()),0,10);
                
               
                $qry->execute(array(':users_name'=>$_POST['username'], 
                                    ':users_password'=>hash("sha256",$passHash),
                                    ':email'=>$_POST['mail']));

                
                $welcome = new Email($_POST['mail'], "Nieuwe gebruiker modeling database");
                $body = "Beste " . $_POST['username'] . "<br />
                        <br />
                        Welkom. Je kan nu inloggen op : https://modeling.oldersma.org<br />
                        <br />
                        Je gebruikersnaam is: ".$_POST['username'] ."<br />
                        <br />
                        Je wachtwoord is : ".$passHash ."<br/><br />
                        <br />
                        Vriendelijke groet";
                        ;

                $welcome->setMessage($body);
                $welcome->sendMail();

                
                Log::addLogEntry($db_link, $_SESSION['usersid'], "User ".htmlentities($_POST['username']) . " added to database.");
                echo '<div class="alert alert-success tempalert">Gebruiker toegevoegd en mail verstuurd.</div>';
            }catch(PDOException  $e)    {
                Log::addLogEntry($db_link, $_SESSION['usersid'], "User ".$_SESSION['username'] . " ".$e->getMessage());
                echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
            }
           
        }
        


        $qry = $db_link->prepare("SELECT * FROM users");
        $qry->execute(array());

        echo '<div class="container">';
        echo '<div class="row top-buffer">';
            echo '<div class="col-9">';


        echo '<table id="membertable" class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Role</th>
            <th scope="col">Last Login</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>';

        $count = 1;
        while($row = $qry->fetch()) {

            echo '<tr>
            <th scope="row">'.$count.'</th>
            <td>'.$row['users_name'].'</td>
            <td>'.$row['role'].'</td>
            <td>'.date("d-M-Y G:i:s", $row['last_login']).'</td>
            <td><a href="?deleteUser='.$row['users_id'].'">Delete</a></td>
                </tr>';


            $count++;

        }
        
        echo ' </tbody>
        </table>';
        
        echo '</div>


        <div class="col-3" style="padding-top:50px">
            <form method="post" action="">
            <table>
                <tr><td>Naam:</td><td><input class="form-control" name="username" type="text" required /></td></tr>
                <tr><td>Email:</td><td><input class="form-control" name="mail" type="email" required/></td></tr>
                <tr><td></td><td><input type="submit" name="add_user" value="Toevoegen" class="btn btn-primary btn-sm" /></td></tr>
            </table>
            </form>
        </div>



        </div>
        </div>';
        

    ?>