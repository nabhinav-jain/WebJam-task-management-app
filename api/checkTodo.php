<?php
session_start();
include "../dbconnect.php";
if($_SERVER['REQUEST_METHOD']=="POST"){
     if(!$_SESSION['isLogin']){
        header('location: index.php');
     }
     $todo_id=$_POST['modalTodoId'];

     $stmt=$conn->prepare('update todo set status=1 where id=?');
     $stmt->bind_param("i",$todo_id);
   
     if($stmt->execute()){
        echo json_encode(['status'=>'success','message'=>'status changed to done']);

     }else{
        echo json_encode(['status'=>'failed','message'=>'Error Occured']);

     }
}