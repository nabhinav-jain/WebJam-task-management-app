<?php
include('header.php');

if(!$_SESSION['isLogin']){
    header("Location: index.php");
    exit;
}
include("includes/headbar.php");
include("includes/sidebar.php");
// header.php included anywhere needs body html closing tags
?>


<div class="main-content-container">
    <?php
    if ($_GET['code'] == 'todo') {
        echo "<p>fggfffffffffffffffffffffffffffffff</p>";
    } else if ($_GET['code'] == 'notes') {
        echo "<p>Ffffffffffffffreeeeeeeeeeeeeeeeeeeeeeeeeee</p>";
    }
    ?>
</div>