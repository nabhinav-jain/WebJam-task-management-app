<?php
include "../dbconnect.php";

   
    if($_SERVER['REQUEST_METHOD']="GET"){
        $user_id=$_GET['user_id'];
    

    $stmt = $conn->prepare("SELECT * FROM todo WHERE user_id = ?");
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $res = $stmt->get_result(); 

    $todos = [];
    while ($todo = $res->fetch_assoc()) {
        $todos[] = $todo; 
    }

    echo json_encode(['status' => 'success', 'todos' => $todos]);
}

?>
