<?php
include 'config.php';
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName) or die('Unable to connect');
if(mysqli_connect_error($con))
{
  echo "Failed to Connect to Database ".mysqli_connect_error();
}
$search_query=$_POST['heading'];
$sql="SELECT `description`, `source`, `time_of_post`, `name`, `email` FROM `news_info` WHERE `heading`='$search_query'";
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