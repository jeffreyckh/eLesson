<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    $uid = $_GET['uid'];
    $query = " select * from user where userid = $uid";
    $result = mysql_query($query);
    while($rows=mysql_fetch_object($result))
    {
        $uname = $rows->username;
    }
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>Reply</title>
  <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>   
</head>
<body>
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="viewfeedback.php">Feedback</a></li>
    <li class="active">Reply</li>
    </ol>

    <div align = "center">
    <table class="table table-bordered">
    <form action="" method="post">
        <tr>
            <td width="20%">Message: </td><td><textarea name = "message" rows="5" cols="100"></textarea></td>
        </tr>
    </table>
        <input class="btn btn-default" type="submit" name="submit" value="Submit">
        <?php
            if(isset($_POST['submit']))
            {
                $dt = date("Y-m-d H:i:s");
                $content = $_POST['message'];

                $nInfo="insert into notification(type,receiver_id,date,message,readnotification) values('Reply','$uid','$dt','$content','0')";
                if(!mysql_query($nInfo))
                {
                    die("Unable to store the reply into database.".mysql_error());
                }
                echo '<script> alert("Reply was sent!") </script>';
      			echo '<script language="JavaScript"> window.location.href ="viewfeedback.php" </script>'; 
            }
        ?>
    </form>
    </div> 
    </body>
    </html>