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
        echo '<div class="p-4">';
        echo '<table class="w-full text-white bg-gray-800 border border-gray-700 rounded-lg">';
        echo '<thead>';
        echo '<tr class="bg-red-600 text-white text-left">';
        echo '<th class="px-4 py-2">Todo</th>';
        echo '<th class="px-4 py-2">Created At</th>';
        echo '<th class="px-4 py-2">Due Time</th>';
        echo '<th class="px-4 py-2">Current Time</th>';
        echo '<th class="px-4 py-2">Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($todoArray['todos'] as $todo) {
            echo '<tr class="border-b border-gray-700">';
            echo '<td class="px-4 py-2">' . htmlspecialchars($todo['todo']) . '</td>';
            echo '<td class="px-4 py-2">' . htmlspecialchars($todo['created_at']) . '</td>';
            echo '<td class="px-4 py-2">' . htmlspecialchars($todo['due_time']) . '</td>';
            echo '<td class="px-4 py-2">' . date('Y-m-d H:i') . '</td>'; 
            echo '<td class="px-4 py-2 text-center">';
            echo '<input type="checkbox" ' . ($todo['status'] == 1 ? 'checked' : '') . ' class="w-5 h-5">';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p class="text-white text-center">No todos found!</p>';
    }
}
else if (isset($_GET['code'])&&$_GET['code'] == 'notes') {

    }
    ?>
</div>