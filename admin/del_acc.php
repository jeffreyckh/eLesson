<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
require_once('../view/userView.php');
$user = new userView();
$m_id=intval($_REQUEST['userid']);
$query="select username from user where userid = $m_id";
$result=mysql_query($query);
while($m_rows=mysql_fetch_object($result))
{
    $m_username=$m_rows->username;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Delete Announcement</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="manageAccount.php">Account</a></li>
    <li class="active">Delete Account</li>
    </ol>
    Delete Account
    <hr>
    <div class="alert alert-warning" role="alert">
      <strong>Are you sure you wan to delete this user?</strong>
      <br>
    <form action="?action=delannouncement?userid=<?php echo $m_id ?>" method="POST">
    <input type="hidden" name="userid" value="<?php echo $m_id ?>">
            <legend>User:</legend>
            <textarea name="username" id="username"><?php echo strip_tags($m_username); ?></textarea>
    <br>
    <input type="submit" class = "btn btn-default" name = "submit" value="Yes">
    <a class="btn btn-default" href="managaAccount.php">No</a>
      <?php
          $user->delAcc()
      ?>
    </form>
    </div>
</body>
</html>