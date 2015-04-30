<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
require_once('../view/announcementView.php');
$announcement = new announcementView();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Announcement</title>
    <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
</head>
<body>
  <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li class="active">Announcement</li>
    </ol>
    <div align="right">
    <form method="post" action="add_announcement.php">
      <input type="submit" class = "btn btn-default" value="Add Announcement" name="submit"/>
    </form>
  </div>
    <hr>
      <table id = "announcement" class="table table-striped table-bordered" cellspacing="0">
        <thead>
            <th align="right">No</th>
            <th align="right">Announcement</th>
            <th align="right">Posted On</th>
            <th align="right">Action</th>
        </thead>
            <?php
                $query="select * from announcement order by taskid DESC";
                $result=mysql_query($query,$link);
                echo "<tbody>";
                while($a_rows=mysql_fetch_object($result))
                {
            ?>
                    <tr>
                    <td align="left" width="5%"><?php echo $a_rows->taskid ?></a></td>
                    <td align="left" width="50%"><?php echo $a_rows->taskname ?></a></td>
                    <td align="left" width="25%"><?php echo $a_rows->taskdate ?></td>
                    <td align="left" width="10%">
                        <a href="edit_announcement.php?taskid=<?php echo $a_rows->taskid ?>">
                            <img id="action-icon" src="../img/modifyicon2_600x600.png">
                            <!-- Modify -->
                        </a>
                        <a href="del_announcement.php?taskid=<?php echo $a_rows->taskid ?>">
                            <img id="action-icon" src="../img/deleteicon2_600x600.png">
                            <!-- Delete -->
                        </a>
                    </td>
                </tr>                
            <?php
                }
                    mysql_close($link);
            ?>
            </tbody> 
    </table>
<script>
$(document).ready(function(){
    $('#announcement').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});
</script>
</body>
</html>