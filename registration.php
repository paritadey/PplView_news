<?php
if($_SERVER['REQUEST_METHOD']=='POST'){

include 'config.php';

 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);

    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone= $_POST['phone'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $edu_details = $_POST['edu_details'];
    
   $CheckSQL = "SELECT * FROM `people_view_user_register` WHERE email='$email'";
 
 $check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));
 
 if(isset($check)){

 echo 'Email Already Exist';

 }
else{ 
$Sql_Query = "INSERT INTO `people_view_user_register`(`email`, `name`, `phone`, `password`, `dob`, `gender`, `address`, `edu_details`) VALUES  ('$email','$name','$phone', '$password', '$dob', '$gender', '$address', '$edu_details')";

 if(mysqli_query($con,$Sql_Query))
{
 echo 'Registration Successfully';
}
else
{
 echo 'Something went wrong';
 }
 }
}
 mysqli_close($con);

?>