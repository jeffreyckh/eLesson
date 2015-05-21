<?php
session_start();
$urank = $_SESSION['rank'];
$uid = $_SESSION['userid'];
if ($urank == 3)
{
  echo '<script language="javascript">';
  echo 'alert("You have no permission to access here")';
  echo '</script>';
  
  header("Location: ../user/userHome.php");
  die();
}
include'../inc/db_config.php';
include '../inc/header.php';
require_once('../view/userView.php');
$user = new userView();
$t = date("Y-m-d H:i:s");
$tnow = date_create ("$t");
$m_id=intval($_REQUEST['userid']);
$query="select * from user where userid=$m_id";
$result=mysql_query($query);
while($m_rows=mysql_fetch_object($result))
{
    $m_username=$m_rows->username;
    $mailaddr = $m_rows->email;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Send Reminder Mail</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="manageAccount.php">Account</a></li>
    <li class="active">Send Reminder Mail</li>
    </ol>
    <div align = "center">
    <table class="table table-bordered">
      <tr>
        <td width="20%" >UserName: </td><td><?php echo $m_username ?></td>
      </tr>
      <tr>
        <td width="20%">E-Mail: </td><td><?php echo $mailaddr ?></td>
      </tr>
      <tr>
        <?php
          $query1="select * from user_to_lesson where userid = $m_id";
          $result1=mysql_query($query1);

          $lessonsNdate = "";

          while($u_rows=mysql_fetch_object($result1))
          {
            $uid = $u_rows->userid;
            $lid = $u_rows->lessonid;
            $vdate = $u_rows->viewtime;
            $vtime = date_create ("$vdate");
            $diff=date_diff($vtime,$tnow);
            $lquery = "select * from lesson where lessonid = $lid";
            $lresult = mysql_query($lquery);
            while($l_rows = mysql_fetch_object($lresult))
            {
              $lname = $l_rows->lessonname;
            }
            $days = $diff->format("%d");
            if($days >= 7)
            {
              $lessonsNdate .= " [ " . $lname . " = Last view on " . $diff->format("%d days") . " ago ]. ";
            }
          }
          $display_msg1 = 'Hello, this is a gentle reminder to inform you still have uncompleted lesson. ';
          $display_msg2 = ' This is an auto-generated email, please do not reply.';
        ?>
        <td width="20%">Mail Content: </td><td><?php echo $display_msg1 . $lessonsNdate . $display_msg2 ?></td>
      </tr>
      <tr>
        <form action="" method="post">
        <td width="20%">Additional Message: </td><td><input type="text" name="xtraMailMsg2">&emsp;* You can add in additional message into the Reminder Mail or leave it blank *</td>
      </tr>
    </table>
    <br>
    <input class="btn btn-default" type="submit" name="sendReminder" value="Send Reminder Mail">
    </div> 
    <?php
    if(isset($_POST['sendReminder']))
    {
      $sbj = 'Reminder of continue your lessons';
      $dt = date("Y-m-d H:i:s");
      $xtraMsg = $_POST['xtraMailMsg2'];
      $msg = $display_msg1 . $lessonsNdate . $xtraMsg . $display_msg2;

      mail($mailaddr, $sbj, $msg, "From: e-Lesson");
      $mailInfo="INSERT INTO notification(type,receiver_id,date,receiver,message,readnotification,sender_id) values('Reminder','$m_id','$dt','$mailaddr','$msg','0','$uid ')";
      if(!mysql_query($mailInfo))
      {
        die("Unable to store the mail into database.".mysql_error());
      }
      $user->reminderMailSent();
    }
    ?></form>
</body>
</html>