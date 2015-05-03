<?php
include('inc/db_config.php');
class DatabaseController
{
  
 function registerUser($username,$password,$position,$email,$name){
    $password = md5($password);
    $query = "INSERT INTO user( username ,  password ,  name ,  email , position, rank) 
   	VALUES ('$username','$password','$name','$email','$position', 3)";
 	  $result = mysql_query($query)  or die ('Error updating database: ' . mysql_error());
    echo '<script> alert("Registration Successful!") </script>';
    echo '<script language="JavaScript"> window.location.href ="login.php" </script>';
  }

  public function selectUser($username,$password)
  {

  	$query = "SELECT * FROM user WHERE username= '$username' and password= '$password' limit 1";
  	$result = mysql_query($query);
    $res = mysql_fetch_assoc($result);
    $_SESSION['userid'] = $res['userid'];
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
      elseif ($rank == 3) 
      {
      $_SESSION['username'] = $username;
      header('Location: user/userHome.php');
      }
    }
    else
    {
      echo 'Wrong!!';
    }
  }
  // Retrive Password
  public function retrivePass($email)
  {
    $query = " SELECT * FROM user WHERE email = '$email' limit 1";
    $result = mysql_query($query);
    while($m_rows=mysql_fetch_object($result))
    {
      $password = $m_rows->password;
    }

    $to = '$email';
    $subject = "Password";

    $message = "
    <html>
    <head>
    <title>Password</title>
    </head>
    <body>
    <p>This email contains password</p>
    <table>
    <tr>
    <th>Password :". $password ."</th>
    </table>
    </body>
    </html>
    ";
    
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // More headers
    $headers .= 'From: <jeffrey_ckh@hotmail.com>' . "\r\n";
    
    mail($to,$subject,$message,$headers);
  }


// Add annoucement database controller
  public function addAnnounce($taskname,$taskdate)
  {
    $query = "INSERT INTO announcement(taskname,taskdate) VALUES ('$taskname','$taskdate')";
    $result = mysql_query($query)  or die ('Error updating database: ' . mysql_error());
  }


 }

?>