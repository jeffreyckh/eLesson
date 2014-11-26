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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../jscss/ckeditor/ckeditor.js"></script>
     <script type="text/javascript" src="../jscss/tablesorter/js/jquery.tablesorter.js"></script>
     <script src="../jscss/tablesorter/js/jquery.tablesorter.widgets.min.js"></script> 
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

    <script>
    function show_popup() {
        var p = window.createPopup()
        var pbody = p.document.body
        pbody.style.backgroundColor = "lime"
        pbody.style.border = "solid black 1px"
        pbody.innerHTML = "This is a pop-up! Click outside to close."
        p.show(150,150,200,50,document.body)
    }

    </script>

<!--<a href="edit_courses.php" onclick="javascript:void window.open('edit_courses.php','1414934651699','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Pop-up Window</a>-->
    
    Total Courses:<font color="red"><?php echo $count; ?></font>|<a href="add_courses.php">Add New Course</a>
    
        <table id = "course" class="tablesorting">
        <thead>
        <th align="left">Course ID</th>
        <th align="left">Course Name</th>
        <th align="left">Created</th>
        <th align="left">Modify</th>
        <th align="left">Delete</th>
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
                <td align="left" width="100"><a href="edit_courses.php?cid=<?php echo $a_rows->courseid ?>">Modify</a></td>
                <td align="left" width="100"><a href="delete_courses.php?cid=<?php echo $a_rows->courseid ?>">Delete</a></td>
                </tr> 
                              
        <?php
            }
                mysql_close($link);
        ?>
        </tbody> 
        </table>
            <form action="search.php" method="post">
                Select Check:
                    <select name="select">
                        <option value="courseid" selected>Course ID</option>
                        <option value="coursename">Course Name</option>
                        <option value="createdate">Create Date</option>
                    </select>
                    Value: <input type="text" name="values">
                    <input type="submit" value="Check Total">
            </form>

    </center>
<script>
$(document).ready(function(){
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
});
</script>
</body>
</html>