<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){

 include 'config.php';
 
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
 $email = $_POST['email'];
 $password = $_POST['password'];
 
 $Sql_Query = "UPDATE `people_view_user_register` SET `password`='$password' WHERE `email`='$email'";
 
 $check = mysqli_fetch_array(mysqli_query($con,$Sql_Query));
 
 if(isset($check)){
 
 echo "Username is Present";
 }
 else{
 echo "Password Updated";
 }
 
 }else{
 echo "Check Again";
 }
mysqli_close($con);

?>