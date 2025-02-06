<?php
include("../dbconnect.php");
if($_SERVER['REQUEST_METHOD']=="POST"){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $hash=md5($password);
   $stmt= $conn->prepare("select * from users where username=? and password=?");
   $stmt->bind_param("ss",$username,$hash);

    $stmt->execute();
    $res=$stmt->get_result();

    if ($res->num_rows == 1) {
        echo json_encode(['status' => 'success', 'message' => 'login successful']);
    } else {
        echo json_encode(['status' => 'failed', 'message' => 'No user found']);
    }
    
}