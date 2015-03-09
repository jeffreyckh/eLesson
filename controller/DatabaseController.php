<?php
include('inc/db_config.php');
class DatabaseController
{
<<<<<<< HEAD
 function registerUser($username,$password,$position,$email,$name){
    $password = md5($password);
    $query = "INSERT INTO user( username ,  password ,  name ,  email , position) 
   	VALUES ('$username','$password','$name','$email','$position')";
 	$result = mysql_query($query)  or die ('Error updating database: ' . mysql_error());
=======
  
 function registerUser($username,$password,$position,$email,$name){
    $password = md5($password);
    $query = "INSERT INTO user( username ,  password ,  name ,  email , position, rank) 
   	VALUES ('$username','$password','$name','$email','$position', 2)";
 	  $result = mysql_query($query)  or die ('Error updating database: ' . mysql_error());
    echo '<script> alert("Registration Successful!") </script>';
    echo '<script language="JavaScript"> window.location.href ="login.php" </script>';
>>>>>>> origin/kit
  }

  public function selectUser($username,$password)
  {

<<<<<<< HEAD
  	$query = "SELECT username FROM user WHERE username= '$username' and password= '$password' limit 1";
  	$result = mysql_query($query);
    $res = mysql_fetch_array($result);

    if($res)
    {
      $_SESSION['username'] = $username;
      header('Location: admin/TestingHome.php');
      exit;
=======
  	$query = "SELECT * FROM user WHERE username= '$username' and password= '$password' limit 1";
  	$result = mysql_query($query);
    $res = mysql_fetch_assoc($result);
    $_SESSION['rank'] = $res['rank'];
    $rank = $_SESSION['rank'];
    if($res)
    {
      if($rank == 1)
      {
      $_SESSION['username'] = $username;
      header('Location: admin/adminHome.php');
      exit;
      }
      elseif ($rank == 2) 
      {
      $_SESSION['username'] = $username;
      header('Location: user/userHome.php');
      }
>>>>>>> origin/kit
    }
    else
    {
      echo 'Wrong!!';
    }
  }
<<<<<<< HEAD
=======


>>>>>>> origin/kit
// Add annoucement database controller
  public function addAnnounce($taskname,$taskdate)
  {
    $query = "INSERT INTO announcement(taskname,taskdate) VALUES ('$taskname','$taskdate')";
    $result = mysql_query($query)  or die ('Error updating database: ' . mysql_error());
  }


 }

?>