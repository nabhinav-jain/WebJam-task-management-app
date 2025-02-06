<?php
include('header.php');

if(!$_SESSION['isLogin']){
    header("Location: index.php");
    exit;
}
include("includes/headbar.php");
include("includes/sidebar.php");
// header.php included anywhere needs body html closing tags
$user_id=$_SESSION['user_id'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $baseurl."api/getTodo.php?user_id=$user_id"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curlResult = curl_exec($ch);

if ($curlResult === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    $responseData = json_decode($curlResult, true);
    
    echo '<script>';
    echo 'console.log(' . json_encode($responseData) . ');';
    echo '</script>';
    $todoArray=$responseData;
}
curl_close($ch);



?>



<div class="main-content-container">
    <?php
if (isset($_GET['code']) && $_GET['code'] == 'todo') {
    if (isset($todoArray['status']) && $todoArray['status'] === 'success' && isset($todoArray['todos'])) {
        echo '<ul>';
        foreach ($todoArray['todos'] as $todo) {
            echo '<li>';
            echo '<strong>Todo:</strong> ' . htmlspecialchars($todo['todo']) . '<br>';
            echo '<strong>Created At:</strong> ' . htmlspecialchars($todo['created_at']) . '<br>';
            echo '<strong>Due Time:</strong> ' . htmlspecialchars($todo['due_time']);
            echo '</li><br>';
        }
        echo '</ul>';
    } else {
        echo 'No todos found!';
    }
}else if (isset($_GET['code'])&&$_GET['code'] == 'notes') {

    }
    ?>
</div>