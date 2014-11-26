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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../jscss/ckeditor/ckeditor.js"></script>
     <script type="text/javascript" src="../jscss/tablesorter/js/jquery.tablesorter.js"></script>
     <script src="../jscss/tablesorter/js/jquery.tablesorter.widgets.min.js"></script> 
</head>
<body>
  <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li class="active">Announcement</li>
    </ol>

    <form method="post" action="add_announcement.php">
      <input type="submit" class = "btn btn-default" value="Add Announcement" name="submit"/>
    </form>
    <br>
      <table id = "announcement" class="tablesorting">
        <thead>
            <th align="right">No</th>
            <th align="right">Announcement</th>
            <th align="right">Posted On</th>
            <th align="right">Modify</th>
            <th align="right">Delete</th>
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
                    <td align="left" width="10%"><a href="edit_announcement.php?taskid=<?php echo $a_rows->taskid ?>">Modify</a></td>
                    <td align="left" width="10%"><a href="del_announcement.php?taskid=<?php echo $a_rows->taskid ?>">Delete</a></td>
                    </tr>                
            <?php
                }
                    mysql_close($link);
            ?>
            </tbody> 
    </table>
<script>
$(document).ready(function(){
$(function(){
$("#announcement").tablesorter(
{
    theme : 'blue',
 
   // sortList : [[1,0],[2,0],[3,0]],
 
    // header layout template; {icon} needed for some themes
    headerTemplate : '{content}{icon}',
 
    // initialize column styling of the table
    widgets : ["columns"],
    widgetOptions : {
      // change the default column class names
      // primary is the first column sorted, secondary is the second, etc
      columns : [ "primary", "secondary", "tertiary" ]
    }
});
});
});
</script>
</body>
</html>