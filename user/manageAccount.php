<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
$uid = $_SESSION['userid'];
    $query3 = " select * from user where userid = $uid";
    $result3 = mysql_query($query3);
    while($rows=mysql_fetch_object($result3))
    {
        if($rows->rank == 2)
        {
            include '../inc/normalAdminNav.php';
        }
        else
        {
           include 'userNav.php'; 
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Add Question</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
  <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div id="lesson_container">
      <div class = "col-md-4">
      </div>
        
          <form action="" method="post">
        <table id="change-pass" class="change-pwd">
        <tr><td>Current Password :</td> <td><input type="password" name="cpassword"></td></tr>
        <tr><td>New Password :</td> <td><input type="password" name="npassword"></td></tr>
        <tr></tr>
        <tr><td>Re-type Password :</td> <td><input type="password" name="rpassword"></td></tr>
        </table>
        <br>
        <div align = "center" ><input  class="btn btn-default" name="submit" type="submit" value="Change">
          &nbsp&nbsp
          <input  class="btn btn-default" type="reset">
        </div>
      
      <?php
      if(isset($_POST['submit']))
      {
        $validquery = "SELECT password FROM user WHERE userid = $uid";
        $validresult = mysql_query($validquery) or die (mysql_error());
        $password = mysql_result($validresult,0);
        $input_cpass = $_POST['cpassword'];
        if ($input_cpass != "")
        {
          $curr_pass = MD5($input_cpass);
          if($curr_pass == $password)
          {
            $npassword = $_POST['npassword'];
            $rpassword = $_POST['rpassword'];
            if(!empty($npassword))
              {
                if(!empty($rpassword))
                  {
                      {
                        if ($npassword == $rpassword)
                        {
                          $newpassword = md5($npassword);
                          $uquery = "UPDATE user SET password = '$newpassword' WHERE userid = $uid";
                          $uresult = mysql_query($uquery) or die(mysql_error());
                          echo "<script type='text/javascript'>alert('Password changed successfully!')</script>";
                        }
                        else
                        {
                          echo "Password enetered is not same";
                        }
                      }
                      else
                      {
                        echo "The password must be 6 to 13 characters!";
                      }
                  }
                  else
                  {
                    echo "Re-type Password can not be empty!";
                  }
              }
              else
              {
                echo "New Password is empty";
              }
          }
          else
          {
            echo "You have entered wrong password";
          }
        }
        else
        {
          echo "Current password can not be empty!";
        }
      }
      ?>
    </form>
    </div>
  </body>
  </html>