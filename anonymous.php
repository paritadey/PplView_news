<?php
if($_SERVER['REQUEST_METHOD']=='POST'){

include 'config.php';

 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);

    $deviceid = $_POST['deviceid'];
    $dob =$_POST['dob'];
    $gender=$_POST['gender'];
    $address=$_POST['address'];
    $details=$_POST['details'];
    $password=$_POST['password'];
    $userid = uniqid('psv-ann-user');
    $name= "Anonymous";
    
   $CheckSQL = "SELECT * FROM `anonymous` WHERE deviceid='$deviceid'";
 
 $check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));
 
 if(isset($check)){

 echo 'User is present as anonymous';

 }
else{ 
$Sql_Query =$Sql_Query = " INSERT INTO `anonymous`(`deviceid`, `dob`, `gender`, `address`, `details`, `password`, `name`, `appuserid`) VALUES ('$deviceid', '$dob', '$gender', '$address', '$details', '$password', '$name', '$userid')";
 if(mysqli_query($con,$Sql_Query))
{
 echo 'Anonymous Details Updated Successfully';
}
else
{
 echo 'Something went wrong';
 }
 }
}
 mysqli_close($con);

?>