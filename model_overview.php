<?php
if (!isset($_SESSION)) session_start();
include_once("includes/sessioncheck.inc.php");
include_once("includes/header.inc.php");
include_once("includes/menu.inc.php");


?>

<script>

$('#deleteModelModal').on('show.bs.modal', function(e) {
    alert()
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});

</script>

<?php

if(isset($_GET['remove_model'])){



}












echo '<div class="container">';

echo '<div class="row buffer" >';
echo '<div class="col-12">';
echo '<h3>Modellen</h3>';
echo '</div>';
echo '</div>';


$qry = $db_link->prepare("SELECT brand,imagepath,name,users_models.um_id,shared FROM users_models,models,brands WHERE models.models_brand=brands.id 
                                                                                        AND users_models.model_id = models_id 
                                                                                         
                                                                                          AND users_models.user_id= :userID");
$qry->execute(array(':userID' => $_SESSION['usersid']));


if ($qry->rowCount() == 0) {

    echo "Nog geen modellen ingevoerd";

}

while ($row = $qry->fetch()) {
    echo '
        <div class="row buffer">';
        echo '<div class="col-10">';
            // echo '<a href="models.php?used_model='.$row['um_id'].'" >';
                    echo '<div class="row">
                            <div class="col-1">';
                                echo '<img class="logo_small" src="' . $row['imagepath'] . '" >';
                                echo '</div>';
                                echo '<div class="hidden-xs-down col-2">';
                                echo $row['brand'];
                                echo '</div>';
                                echo '<div class="col-6">';
                                echo $row['name'];
                                echo '</div>';
                                echo '<div class="col-1">';
                                if($row['shared'] == 1) echo "<label class=\"badge badge-success\">Shared</label>";
                                echo '</div>';
                                echo '<div class="col-1">
                                <a href="models.php?used_model='.$row['um_id'].'" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </div>';
                                echo '<div class="col-1">
                                <a href="#" data-href="model_overview.php?remove_model='.$row['um_id'].'" data-toggle="modal" data-target="#deleteModelModal"><i class="fa fa-ban" aria-hidden="true"></i></a>
                                </div>';
                                echo '</div>';
            // echo '</a>';
            echo '</div>';
      echo '</div>';


                        echo '<!-- Confirm deletion -->';
                        echo '<div class="modal fade" id="deleteModelModal" tabindex="-1" role="dialog" aria-labelledby="deleteModelModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="deleteModelModalLabel">Weet u het zeker?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                            Wilt u dit model inclusief alle afbeeldingen en kleur-referenties verwijderen ?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-ok">Save changes</button>
                            </div>
                        </div>
                        </div>
                    </div>';
}



echo '<div class="row buffer" >';
echo '<div class="col-12">';
echo '<h3>Gedeelde modellen van anderen</h3>';
echo '</div>';
echo '</div>';



$qry = $db_link->prepare("SELECT brand,imagepath,name,users_models.um_id FROM users_models,models,brands WHERE models.models_brand=brands.id 
        AND users_models.model_id = models_id 
         
          AND users_models.user_id != :userID AND users_models.shared= 1");
$qry->execute(array(':userID' => $_SESSION['usersid']));


if ($qry->rowCount() == 0) {

    echo "Nog geen gedeelde modellen bij anderen ingevoerd";

}
            // echo '<pre>';
while ($row = $qry->fetch()) {
    echo '
            <div class="row buffer">';
            echo '<div class="col-10">';
            echo '<a href="models.php?used_model='.$row['um_id'].'" >';
                echo '<div class="row"><div class="col-1">';
                echo '<img class="logo_small" src="' . $row['imagepath'] . '" >';
                echo '</div>';
                echo '<div class="hidden-xs-down col-2">';
                echo $row['brand'];
                echo '</div>';
                echo '<div class="col-9">';
                echo $row['name'];
                echo '</div></div>';
           
            echo '</a>';
            echo '</div>';




    echo '</div>';

}


echo '</div>';


?>