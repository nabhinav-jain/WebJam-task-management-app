<?php
include("../dbconnect.php");
session_start();
if($_SERVER['REQUEST_METHOD']=="POST"){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $hash=md5($password);
   $stmt= $conn->prepare("select * from users where username=? and password=?");
   $stmt->bind_param("ss",$username,$hash);

    $stmt->execute();
    $res=$stmt->get_result();

    if ($res->num_rows == 1) {
        $result=$res->fetch_assoc();
        $_SESSION['user_id']=$result['id'];
        $_SESSION['isLogin']=true;
        echo json_encode(['status' => 'success', 'message' => 'login successful']);
    } else {
        echo json_encode(['status' => 'failed', 'message' => 'No user found']);
    }
    
}