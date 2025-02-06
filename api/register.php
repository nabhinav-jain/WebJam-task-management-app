<?php
include "../dbconnect.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
      $name=$_POST['username'];
      $password=$_POST['password'];
      $conf_pass=$_POST['confirm_password'];
      
      if($password!=$conf_pass){
           echo json_encode(['status'=>'failed', 'message'=>'password do not match']);
           exit; 
      }
      $hash_pass=md5($password);

      $statement=$conn->prepare("insert into users (username,password,unhashed_pass) VALUES(?,?,?)");

      $statement->bind_param("sss",$name,$hash_pass,$password);
      
      if($statement->execute()){
        echo json_encode(['status'=>'Success','message'=>'Record created successfully']);
      }else{
        echo json_encode(['status'=>'failed','message'=>'Record creatation failure']);
      }
}