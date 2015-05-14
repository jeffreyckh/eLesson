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
        <table cellspacing="10">
          <form action="" method="post">
        <tr><td>Current Password :</td> <td><input type="text" name="cpassword"></td></tr>
        <tr><td>New Password :</td> <td><input type="text" name="npassword"></td></tr>
        <tr></tr>
        <tr><td>Re-type Password :</td> <td><input type="text" name="rpassword"></td></tr>
        </table>
        <br>
        <div align = "center" ><input  class="btn btn-default" name="submit" type="submit" value="Change">&nbsp&nbsp<input  class="btn btn-default" type="reset"></div>
      
      <?php
      if(isset($_POST['submit']))
      {
        $validquery = "SELECT password FROM user WHERE userid = $uid";
        $validresult = mysql_query($validquery) or die (mysql_error());
        $password = md5(mysql_result($validresult,0));
        $input_cpass = md5($_POST['cpassword']);
        echo "??".$password;
        echo "<br>";
        echo 'alert("'.$input_cpass.'")';
        if($input_cpass == $password)
        {
          $npassword = md5($_POST['npassword']);
          $rpassword = md5($_POST['rpassword']);
          if ($npassword == $rpassword)
          {
            $uquery = "UPDATE user SET password = $npassword WHERE userid = $uid";
            $uresult = mysql_query($uquery) or die(mysql_error());
          }
          else
          {
            echo "Password enetered is not same";
          }
        }
        else
        {
          echo "You have entered wrong password";
        }
      }
      ?>
    </form>
    </div>
  </body>
  </html>