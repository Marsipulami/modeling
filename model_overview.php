<?php
if (!isset($_SESSION)) session_start();
include_once("includes/sessioncheck.inc.php");
include_once("includes/header.inc.php");
include_once("includes/menu.inc.php");



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
            echo '<a href="models.php?used_model='.$row['um_id'].'" >';
                    echo '<div class="row">
                            <div class="col-1">';
                                echo '<img class="logo_small" src="' . $row['imagepath'] . '" >';
                                echo '</div>';
                                echo '<div class="hidden-xs-down col-2">';
                                echo $row['brand'];
                                echo '</div>';
                                echo '<div class="col-7">';
                                echo $row['name'];
                                echo '</div>';
                                echo '<div class="col-1">';
                                if($row['shared'] == 1) echo "<label class=\"badge badge-success\">Shared</label>";
                                echo '</div>';
                                echo '<div class="col-1">
                                <a href="" ><i class="fa fa-ban" aria-hidden="true"></i></a>
                                </div></div>';
            echo '</a>';
    echo '</div>';



    echo '</div>';

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