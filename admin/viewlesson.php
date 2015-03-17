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
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Lessons</title>
    <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
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
    <li class="active">Lessons</li>
    </ol>
    <center>
    <?php
        $query_count="select count(*) from lesson";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>


    
    <div align = "right">Total Courses:<font color="red"><?php echo $count; ?></font>&nbsp<a href="add_lessons2.php" class = " btn btn-default">Add New Lesson</a></div>
        <hr>
        <table id="lesson" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <th align="left">Lesson ID</th>
        <th align="left">Lesson Name</th>
        <th align="left">Created</th>
        <th align="left">Course</th>
        <th align="left">Modify</th>
        <th align="left">Delete</th>
        </thead>
        <?php
            $query="select * from lesson order by direction_id";
            //$query2="select * from course";
            $result=mysql_query($query,$link);
            //$result2=mysql_query($query2,$link);
           echo "<tbody>";
            while($a_rows=mysql_fetch_object($result))
            {

                $query2="select * from course";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {
                    if($a_rows->direction_id == $b_rows->courseid)
                    {$cn = $b_rows->coursename;}

                
            }


        ?>
                <tr>
                <td align="left" width="5%"><?php echo $a_rows->lessonid ?></a></td>
                <td align="left" width="30%"><a href="lessons_info.php?lid=<?php echo $a_rows->lessonid ?>"><?php echo $a_rows->lessonname ?></a></td>
                <td align="left" width="20%"><?php echo $a_rows->created ?></td>
                <td align="left" width="25%"><?php echo $cn ?></td>
                <td align="left" width="10%"><a href="edit_lessons.php?lid=<?php echo $a_rows->lessonid ?>">Modify</a></td>
                <td align="left" width="10%"><a href="del_viewlesson.php?lid=<?php echo $a_rows->lessonid ?>">Delete</a></td>
                </tr>                
        <?php

            }
                mysql_close($link);
        ?>
        </body>
        </table>
    </center>
    <script>
    $(document).ready(function(){
    $('#lesson').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
    });
    </script>
    </body>
    </html>