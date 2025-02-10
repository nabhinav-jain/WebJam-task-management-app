<?php
include "../dbconnect.php";
session_start();

if(isset($_SESSION['isLogin'])&&$_SESSION['isLogin']){

    $user_id=$_SESSION['user_id'];
    $taskName=$_POST['taskName'];
    $taskDueTime=$_POST['taskDueTime'];

    $taskDueTime = date("Y-m-d H:i:s", strtotime($taskDueTime));
    $stmt=$conn->prepare("insert into todo(user_id,todo,due_time) Values(?,?,?)");
    $stmt->bind_param("iss",$user_id,$taskName,$taskDueTime);

    if($stmt->execute()){
        echo json_encode(['status'=>'success','message'=>'task created successfully']);
    }else{
        
        echo json_encode(['status'=>'failed','message'=>'Error in creating Task: ' . $stmt->error]);

    }
}else{
    header('location: index.php');
    exit;
}