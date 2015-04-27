<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="course">
  <meta name="description" content="course">
  <title>Course</title>
    <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>   
     <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
 </head>
<body>
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li class="active">Courses</li>
    </ol>
    <center>
    <?php
        $query_count="select count(*) from course";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>
   
    <div align = "right">Total Courses:<font color="red"><?php echo $count; ?></font>&nbsp<a href="add_courses.php" class = " btn btn-default">Add New Course</a></div>
    <hr>
        <table id="course" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <th align="left">Course ID</th>
        <th align="left">Course Name</th>
        <th align="left">Created</th>
        <th align="left">Admin In Charge</th>
        <th align="center" style="text-align:center;">Actions</th>
        </thead>
        <?php
            $query="select * from course order by courseid";
            $result=mysql_query($query,$link);
            echo "<tbody>";
            while($a_rows=mysql_fetch_object($result))
            {
        ?>
                <tr>
                <td align="left" width="100"><?php echo $a_rows->courseid ?></a></td>
                <td align="left" width="100"><a href="courses_info.php?cid=<?php echo $a_rows->courseid ?>"><?php echo $a_rows->coursename ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->created ?></td>
                <td align="left" width="100">
                    <?php
                        $uquery = "select * from permission where courseid = $a_rows->courseid";
                        $uresult = mysql_query($uquery);
                        while($u_rows=mysql_fetch_object($uresult))
                        {
                            $aquery = "select * from user where userid = $u_rows->userid";
                            $aresult = mysql_query($aquery);
                            while($ac_rows=mysql_fetch_object($aresult))
                            {
                                echo $ac_rows->username;
                            }

                        }

                        
                    ?>
                </td>
                <td align="center" width="15%">
                    <a href="edit_courses.php?cid=<?php echo $a_rows->courseid ?>" title="Modify">
                        <img id="action-icon" src="../img/modifyicon2_600x600.png">
                        <!-- Modify -->
                    </a>
                    <a href="del_course.php?cid=<?php echo $a_rows->courseid ?>" title="Delete">
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

    </center>
<script>
$(document).ready(function(){
    $('#course').DataTable(
        {
            
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});
/*$(document).ready(function(){
$(function(){
$("#course").tablesorter(
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
});*/
</script>
</body>
</html>