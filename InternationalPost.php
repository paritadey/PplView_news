<?php
include 'config.php';
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName) or die('Unable to connect');
if(mysqli_connect_error($con))
{
  echo "Failed to Connect to Database ".mysqli_connect_error();
}

$sql="SELECT `heading` FROM `news_info` WHERE `catagory`='international' GROUP BY time_of_post DESC";
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