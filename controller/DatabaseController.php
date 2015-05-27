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
    $_SESSION['rank'] = $res['rank'];
    $_SESSION['userid'] = $res['userid'];
    $_SESSION['username'] = $res['username'];
    $rank = $_SESSION['rank'];
      
      $time = time();
      $month=date("F",$time);
      $year=date("Y",$time);
      $uidquery= mysql_query("SELECT userid FROM user WHERE username = '$username' AND password = '$password' ");

      if(mysql_num_rows($uidquery) != 0) { 
      $uid = mysql_result($uidquery,0);
        $querycheck = "select * from user_view where userid = $uid and usertype = $rank";
        $checkresult = mysql_query($querycheck);
        if(mysql_num_rows($checkresult) == 0)
        {
          $sql = "INSERT INTO  user_view (username,userid,usertype,year)
            VALUES ('$username','$uid', '$rank','$year')" or die(mysql_error());
            mysql_query($sql);
        }

       
      $mysqltesting = "UPDATE user_view SET $month = $month + 1 WHERE userid = $uid and usertype = $rank";
      mysql_query($mysqltesting);
     
    }

    if($res)
    {
      if($rank == 1)
      {
      header('Location: admin/adminHome.php'); 
      exit;
      }
      elseif ($rank == 2) 
      {
      header('Location: user/userHome.php');
      }
      elseif ($rank == 3) 
      {
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