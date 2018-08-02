<?php
if(!isset($_SESSION)) session_start();


        include_once("includes/sessioncheck.inc.php");
        include_once("includes/header.inc.php");
        include_once("includes/menu.inc.php");


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

        if(isset($_POST['save'])){

            // var_dump($_POST);

           
        }
        


        $qry = $db_link->prepare("SELECT * FROM users");
        $qry->execute(array());

        echo '<div class="container">';
        echo '<div class="row top-buffer">';
            echo '<div class="col-12">';


        echo '<table id="membertable" class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Role</th>
            <th scope="col">Last Login</th>
          </tr>
        </thead>
        <tbody>';

        $count = 1;
        while($row = $qry->fetch()) {

            echo '<tr>
            <th scope="row">'.$count.'</th>
            <td>'.$row['users_name'].'</td>
            <td>'.$row['role'].'</td>
            <td>'.date("d-M-Y", $row['last_login']).'</td>
                </tr>';


            $count++;

        }
        
        echo ' </tbody>
        </table>';
        
        echo '</div>
        </div>
        </div>';
        

    ?>