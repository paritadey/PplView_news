<?php
if($_SERVER['REQUEST_METHOD']=='POST'){

include 'config.php';

 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);

    $useremail = $_POST['useremail'];
    $heading = $_POST['heading'];
    $description= $_POST['description'];
    $source = $_POST['source'];
    $timeofpost = $_POST['timeofpost'];
    $author_name = $_POST['author_name'];
    $author_email = $_POST['author_email'];
    $liked_post = $_POST['liked_post'];
    $disliked_post = $_POST['disliked_post'];
    $userposttime = $_POST['userposttime'];
    $usercomment = $_POST['usercomment'];
 
$Sql_Query = "INSERT INTO `Post_details`(`useremail`, `heading`, `description`, `source`, `timeofpost`, `author_name`, `author_email`, `liked_post`, `disliked_post`, `userposttime`, `comment`) VALUES ('$useremail','$heading','$description', '$source', '$timeofpost', '$author_name', '$author_email', '$liked_post', '$disliked_post', '$userposttime', '$usercomment')";

 if(mysqli_query($con,$Sql_Query))
{
 echo 'Working fine';
}
else
{
 echo 'Something went wrong';
 }
 }

 mysqli_close($con);

?>