<?php
include('inc/db_config.php');
class DatabaseController
{
 function registerUser($username,$password,$position,$email,$name){
    $password = md5($password);
    $query = "INSERT INTO user( username ,  password ,  name ,  email , position, rank) 
   	VALUES ('$username','$password','$name','$email','$position', 2)";
 	$result = mysql_query($query)  or die ('Error updating database: ' . mysql_error());
  }

  public function selectUser($username,$password)
  {

  	$query = "SELECT username FROM user WHERE username= '$username' and password= '$password' limit 1";
  	$result = mysql_query($query);
    $res = mysql_fetch_array($result);

    if($res)
    {
      $_SESSION['username'] = $username;
      header('Location: admin/TestingHome.php');
      exit;
    }
    else
    {
      echo 'Wrong!!';
    }
  }
// Add annoucement database controller
  public function addAnnounce($taskname,$taskdate)
  {
    $query = "INSERT INTO announcement(taskname,taskdate) VALUES ('$taskname','$taskdate')";
    $result = mysql_query($query)  or die ('Error updating database: ' . mysql_error());
  }


 }

?>