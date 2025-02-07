<?php

include "../dbconnect.php";
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_SESSION['isLogin']) && !$_SESSION['isLogin']){
        header("location: index.php");
        exit;
    }

    $todo_id=$_POST['deleteTodoModal'];

    $stmt = $conn->prepare("DELETE FROM todo WHERE id = ?");
    $stmt->bind_param("i", $todo_id);
   if( $stmt->execute()){
     echo json_encode(['status'=>'success','message'=>'Deleted successfully']);
   }else{
    echo json_encode(['status'=>'failed','message'=>'Error occured']);

   }

}