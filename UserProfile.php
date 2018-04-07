<?php
include 'config.php';
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName) or die('Unable to connect');
if(mysqli_connect_error($con))
{
  echo "Failed to Connect to Database ".mysqli_connect_error();
}
$search_query=$_POST['myemail'];
$sql="SELECT  `name`, `phone`, `address`, `dob`, `gender`, `edu_details` FROM `people_view_user_register` WHERE email='$search_query'";
$query=mysqli_query($con,$sql);
if($query)
{
    while($row=mysqli_fetch_array($query))
  {
    $data[]=$row;
  }
    print(json_encode($data));
}else
{
  echo('Not Found ');
}
mysqli_close($con);
?>