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

    <link rel="stylesheet" type="text/css" href="style.css"/>

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
    <style>
    label{
      /*display: inline-block;*/
      /*width: 5em;*/
    }
    
    </style>

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

    <div align = "right">
        Total Courses:<font color="red"><?php echo $count; ?></font>&nbsp
        <a href="add_lessons2.php" class = " btn btn-default">Add New Lesson</a>
        <!-- <a href="history_lesson.php" class = " btn btn-default">Lesson History Log</a> -->
    </div>

        <hr>
        <table id="lesson" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <th align="left">Lesson ID</th>
        <th align="left">Lesson Name</th>
        <th align="left">Created</th>
        <th align="left">Course</th>
        <th align="right"  style="text-align:center;">Action</th>
        </thead>
        <?php
            $query  = "SELECT * from lesson order by direction_id";
            //$query2="select * from course";
            $result = mysql_query($query,$link);
            //$result2=mysql_query($query2,$link);
           echo "<tbody>";
            while($a_rows=mysql_fetch_object($result))
            {

                $query2 = "SELECT * from course";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {
                    if($a_rows->direction_id == $b_rows->courseid)
                    {
                        $cn = $b_rows->coursename;
                    }
                }


        ?>
                <tr>
                <td align="left" width="10%"><?php echo $a_rows->lessonid ?></a></td>
                <td align="left" width="30%"><a href="lessons_info.php?lid=<?php echo $a_rows->lessonid ?>"><?php echo $a_rows->lessonname ?></a></td>
                <td align="left" width="10%"><?php echo $a_rows->created ?></td>
                <td align="left" width="20%"><?php echo $cn ?></td>
                <td align="center" width="20%">
                    <a class="action-tooltip" href="edit_lessons.php?lid=<?php echo $a_rows->lessonid ?>" title="Modify">
                        <img id="action-icon" src="../img/modifyicon2_600x600.png">
                        <!-- Modify -->
                    </a>
                    <a class="action-tooltip" href="lesson_history.php?lid=<?php echo $a_rows->lessonid ?>" title="View History">
                        <img id="action-icon" src="../img/historyicon2_600x600.png">
                        <!-- &nbsp;View History&nbsp; -->
                    </a>
                    <a class="action-tooltip" href="del_viewlesson.php?lid=<?php echo $a_rows->lessonid ?>" title="Delete">
                        <img id="action-icon" src="../img/deleteicon2_600x600.png">
                        <!-- Delete -->
                    </a>
                </td>
                </tr>                
        <?php

            }
                mysql_close($link);
        ?>
        </body>
        </table>
    </center>
    <script>
    function toolTip(){
        var jquery_1_11_4 = $.noConflict(true);
        jquery_1_11_4(function(){
          jquery_1_11_4( ".action-tooltip" ).tooltip({
            show: {
              effect: false
            }
          });
        });
    }
    $(document).ready(function(){
        $('#lesson').DataTable(
            { 
                "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
            });
        toolTip();
        $('.next').click(function(){
            toolTip();
        });
        $('.pagination').click(function(){
            toolTip();
        });
    });

    toolTip();
    </script>
    </body>
    </html>