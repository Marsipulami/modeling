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
?>

<script>
        $(document).ready(function () {
             $('#logtable').DataTable(
                "order": [[ 1, "desc" ]]
             );
             $('.dataTables_length').addClass('bs-select');
        });

</script>

<?php


    $qry = $db_link->prepare("SELECT * FROM logging ORDER By logentryid DESC ");
    $qry->execute();
    $brands = null;

    echo '<div class="container">';
                    echo '<div class="row top-buffer">';
                        echo '<div class="col-12">';
                                    

    echo '<table id="logtable" class="table table-striped">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Message</th>
       
        </tr>
    </thead>
    <tbody>';


    while($row = $qry->fetch()) {


        echo '<tr>
        <th scope="row">'.$row['timestamp'].'</th>
        <td>'.$row['logvalue'].'</td>
        
            </tr>';

    }    

    echo ' </tbody>
        </table>';

            echo '</div>';
        echo '</div>';
    echo '</div>';

?>
