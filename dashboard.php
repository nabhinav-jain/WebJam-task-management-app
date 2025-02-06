<?php
include('header.php');

if(!$_SESSION['isLogin']){
    header("Location: login.php");
    exit;
}
include("includes/headbar.php");
include("includes/sidebar.php");
// header.php included anywhere needs body html closing tags