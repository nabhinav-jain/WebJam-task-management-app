<?php
session_start();
$servername="localhost";
$username="root";
$dbname="webjam";
$password="";

$conn=new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    die;
}