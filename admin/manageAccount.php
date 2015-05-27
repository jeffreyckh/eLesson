<?php
session_start();
$urank = $_SESSION['rank'];
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
include 'adminNav.php';
$t = date("Y-m-d H:i:s");
$tnow = date_create ("$t");

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
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
    <!-- jquery UI -->
    <!-- Added on: 11-04-15 -->
    <script src="../jqueryui/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script src="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.css">
    
     <script type="text/javascript">
     
     </script>
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

            <th align="right">UserName</th>
            <th align="right">Name</th>
            <th align="right">Email</th>
            <th align="right">Position</th>
            <th align="right">Rank</th>
            <th align="right">Last View Lesson</th>
            <!-- <th align="right">Send Reminder</th> -->
            <th align="right">Actions</th>
        </thead>
            <?php
                $query="select * from user";
                $result=mysql_query($query,$link);
                echo "<tbody>";
                while($a_rows=mysql_fetch_object($result))
                {
            ?>
                    <tr>
                    <td align="left" width="10%"><a href="userdetail.php?uid=<?php echo $a_rows->userid ?>"><?php echo $a_rows->username ?></a></td>
                    <!--<td align="left" width="10%"><?php echo $a_rows->username ?></a></td>-->
                    <td align="left" width="10%"><?php echo $a_rows->name ?></td>
                    <td align="left" width="15%"><?php echo $a_rows->email ?></td>
                    <td align="left" width="10%"><?php echo $a_rows->position ?></td>
                     <td align="left" width="10%">
                        <?php 
                        if($a_rows->rank == 1)
                        {
                            echo "Super Admin"; 
                        }
                        else if($a_rows->rank == 2)
                        {
                            echo "Admin"; 
                        }
                        else 
                        {
                            echo "User";                        
                        }?>
                    </td>
                    <td align="left" width="10%">
                        <?php
                            $useracc = $a_rows->userid;
                            $queryU2L = "select * from user_to_lesson where userid = $useracc";
                            $resultU2L = mysql_query($queryU2L);
                            $tempdays = 0;
                            while($b_rows=mysql_fetch_object($resultU2L))
                            {
                                $vdate = $b_rows->viewtime;
                                $vtime = date_create ("$vdate");
                                $diff=date_diff($vtime,$tnow);

                                $days = $diff->format("%d");

                                if($days > $tempdays)
                                {
                                    $tempdays = $days;
                                }
                            }
                            if($tempdays >= 7)
                            {
                                echo "<font color='red'>$tempdays days ago</font>";
                            }
                            else
                            {
                                echo "$tempdays days ago";
                            }
                        ?>
                    </td>
                    <td class="accActions" align="left" width="10%">
                        <a class="action-tooltip" href="send_reminder.php?userid=<?php echo $a_rows->userid ?>" title="Send Reminder">
                            <img id="action-icon" src="../img/sendremindericon2_600x600.png">
                            <!-- Send -->
                        </a>
                        <a class="action-tooltip" href="edit_acc.php?userid=<?php echo $a_rows->userid ?>" title="Modify Account">
                            <img id="action-icon" src="../img/modifyicon2_600x600.png">
                            <!-- Modify -->
                        </a>
                        <a class="action-tooltip" href="del_acc.php?userid=<?php echo $a_rows->userid ?>" title="Delete Account">
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
var tool = $.noConflict(true);
$(document).ready(function(){
    $('#user').DataTable(
        {
            "fnDrawCallback": function()
            {
                tool(function()
                {
                  tool( ".action-tooltip" ).tooltip(
                  {
                    show: {
                      effect: false
                    },
                    position: {
                        my: "center top-25",
                        at: "center top-20"
                    },
                    show: false,
                    hide: 
                        false
                    
                  });
                });
            },
            "columnDefs": [
            {
                /*"targets": [ 0 ],
                "visible": false,
                "searchable": false*/

            }],   
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">',
            stateSave: true,
            "aoColumns": [
                null,
                null,
                null,
                null,
                null,
                { "orderSequence": [ "asc" ] },
                { "bSortable": false }
                ]
        });
});
</script>
</body>
</html>