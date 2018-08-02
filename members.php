<?php
if(!isset($_SESSION)) session_start();


        include_once("includes/sessioncheck.inc.php");
        include_once("includes/header.inc.php");
        include_once("includes/menu.inc.php");


        ?>
       
        <?php

        if($_SESSION['role'] !== "1"){
            die('<div class="alert alert-danger">Onvoldoende rechten.</div>');
        }

        if(isset($_POST['save'])){

            // var_dump($_POST);

           
        }
        


        $qry = $db_link->prepare("SELECT * FROM users");
        $qry->execute(array());




        echo '<table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>';


        while($row = $qry->fetch()) {

            echo '<tr>
            <th scope="row">1</th>
            <td>'.$row['users_name'].'</td>
            <td>'.$row['role'].'</td>
            <td>'.date("d-M-Y", $row['last_login']).'</td>
                </tr>';


        }
        
        echo ' </tbody>
        </table>';
        

        

    ?>