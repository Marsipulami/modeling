<?php

include_once("includes/settings.inc.php");
if(!isset($_SESSION['username'])){
    header('Location: '.BASEURI.'/login.php');
  }


?>