<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
//require_once('../view/announcementView.php');
//$announcement = new announcementView();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Manage Account</title>
    <!--<link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />-->
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.bootstrap.css">
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
    <li class="active">Manage Account</li>
    </ol>
    <div align="right">
    </form>
  </div>
  Manage User Account
  <hr>
      <table id = "user" class="table table-striped table-bordered" cellspacing="0">
        <thead>
            <th align="right">User ID</th>
            <th align="right">UserName</th>
            <th align="right">Name</th>
            <th align="right">Email</th>
            <th align="right">Position</th>
            <th align="right">Rank</th>
            <th align="right">Modify</th>
            <th align="right">Delete</th>
        </thead>
            <?php
                $query="select * from user";
                $result=mysql_query($query,$link);
                echo "<tbody>";
                while($a_rows=mysql_fetch_object($result))
                {
            ?>
                    <tr>
                    <td align="left" width="5%"><?php echo $a_rows->userid ?></a></td>
                    <td align="left" width="10%"><?php echo $a_rows->username ?></a></td>
                    <td align="left" width="10%"><?php echo $a_rows->name ?></td>
                    <td align="left" width="20%"><?php echo $a_rows->email ?></td>
                    <td align="left" width="20%"><?php echo $a_rows->position ?></td>
                     <td align="left" width="20%">
                        <?php 
                        if($a_rows->rank == 1)
                        {
                            echo "Admin"; 
                        }
                        else 
                        {
                            echo "User";                        
                        }?>
                    </td>
                    <td align="left" width="10%"><a href="edit_acc.php?userid=<?php echo $a_rows->userid ?>">Modify</a></td>
                    <td align="left" width="10%"><a href="del_acc.php?userid=<?php echo $a_rows->userid ?>">Delete</a></td>
                    </tr>                
            <?php
                }
                    mysql_close($link);
            ?>
            </tbody> 
    </table>
<script>
$(document).ready(function(){
    $('#user').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">',
            stateSave: true,
            "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            { "orderSequence": [ "asc" ] },
            { "orderSequence": [ "asc" ] }
        });
});
</script>
</body>
</html>