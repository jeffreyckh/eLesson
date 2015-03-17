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
  <title>Quiz</title>
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
    <li class="active">Quiz</li>
    </ol>

    <center>
    <?php
        $query_count="select count(*) from quiz";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>



        <div align = "right">Total Quiz:<font color="red"><?php echo $count; ?></font>&nbsp&nbsp<a class = "btn btn-default" href="add_quiz.php">Add Quiz</a>
        <hr>
        <table id="quiz" class="table table-striped table-bordered" cellspacing="0" >
        <thead>    
        <th align="left">Quiz ID</th>
        <th align="left">Quiz Name</th>
        <th align="left">Created</th>
        <th align="left">Lesson</th>
        <th align="left">Course</th>
        <th align="left">Modify</th>
        <th align="left">Delete</th>
        </thead>
        <?php
            $query_all_quiz     = "SELECT * FROM quiz ORDER BY lessonid";
            //$query2="select * from course";
            $result_all_quiz    = mysql_query($query_all_quiz,$link);
            //$result2=mysql_query($query2,$link);
            echo "<tbody>";

            while($a_rows = mysql_fetch_object($result_all_quiz))
            {
                $query_all_lesson   = "SELECT * FROM lesson";
                $result_all_lesson  = mysql_query($query_all_lesson, $link);
                
                while($b_rows=mysql_fetch_object($result_all_lesson))
                {
                    if($a_rows->lessonid == $b_rows->lessonid)
                    {
                        $lessonname = $b_rows->lessonname;
                        $directionid = $b_rows->direction_id;

                            $query_all_course   = "SELECT * FROM course";
                            $result_all_course  = mysql_query($query_all_course, $link);
                            while($c_rows = mysql_fetch_object($result_all_course))
                            {
                                if($directionid == $c_rows->courseid)
                                {
                                $coursename = $c_rows->coursename;
                                }
                
                            }

                    }          
                
                }
        ?>
                <tr>
                <td align="left" width="100"><?php echo $a_rows->quizid ?></a></td>
                <td align="left" width="100"><a href="view_question.php?qid=<?php echo $a_rows->quizid ?>"><?php echo $a_rows->quizname ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->created ?></td>
                <td align="left" width="100"><?php echo $lessonname ?></td>
                <td align="left" width="100"><?php echo $coursename ?></td>
                <td align="left" width="100"><a href="edit_quiz.php?qid=<?php echo $a_rows->quizid ?>">Modify</a></td>
                <td align="left" width="100"><a href="delete_quiz.php?qid=<?php echo $a_rows->quizid ?>">Delete</a></td>
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
    $('#quiz').DataTable(
        {  
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
    });
    </script>
    </body>
    </html>