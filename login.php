<!DOCTYPE html>
<html lang="en">

<style>
body, html {
    height: 100%;
}

.bg { 
    /* The image used */
    background-image: url("images/bg.jpg");

    /* Full height */
    height: 100%; 

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

</style>
<?php

  include("includes/header.inc.php");
//   include_once("includes/sessioncheck.inc.php");







    if(isset($_POST['submit'])){



        $Qry = $db_link->prepare("SELECT * FROM users WHERE users_name = :User AND users_password = :Pass");
        $Qry->execute(array(':User'=>$_POST['username'], ':Pass'=>hash('sha256',$_POST['password'])));

        if($Qry->rowCount() > 0){
            $result = $Qry->fetch();
            session_start();
          

            $_SESSION['username'] = $result['users_name'];
            $_SESSION['usersid'] = $result['users_id'];
            $_SESSION['role'] = $result['role'];

            $Qry = $db_link->prepare("UPDATE users SET last_login = :currentdate WHERE users_id = :userID");
            $Qry->execute(array(':userID'=>$result['users_id'], ':currentdate'=>time()));


            Log::addLogEntry($db_link, $_SESSION['usersid'], "User ".$_SESSION['username'] . " has logged in");

            header('Location: /');

        }else{
            Log::addLogEntry($db_link, $_SESSION['usersid'], "User ".$_POST['username'] . " has failed to log in.");
            echo '<div class="alert alert-danger">Inloggen mislukt.</div>';
        }


        

    }






?>


<body class="bg">



<div class="container">
    

    
    <div class="row logonbox">
    <form method="post" action="" >
        <div class="col-12">
            <div class="row buffer">
                <div class="col-sm-12 col-md-12"><input type="text" placeholder="Username" name="username" class="form-control input-lg"  autofocus/></div>
            </div>
            <div class="row buffer">
                <div class=" col-sm-12 col-md-12"><input type="password" placeholder="Password" name="password" class="form-control input-lg" /></div>
            </div>
            <div class="row buffer">
                <div class="col-sm-12 col-md-12"><input type="submit" name="submit"  value="Logon" /></div>
            </div>
        </div>
        </form>
    </div>
    


</div>

</body>
</html>