 <?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="quiz">
  <meta name="description" content="quiz">
  <title>Quiz</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
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
    <li><a href="userHome.php">Home</a></li>
    <li class="active">Quiz</li>
    </ol>

    <center>
    <?php
        $query_count="select count(*) from quiz";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>



        <div align = "right">Total Quiz:<font color="red"><?php echo $count; ?></font>
        <hr>
        <table id="quiz" class="table table-striped table-bordered" cellspacing="0" >
        <thead>    
        <th align="left">Quiz ID</th>
        <th align="left">Quiz Name</th>
        <th align="left">Created</th>
        <th align="left">Lesson</th>
        <th align="left">Course</th>
        </thead>
        <?php
            $query="select * from quiz order by lessonid";
            //$query2="select * from course";
            $result=mysql_query($query,$link);
            //$result2=mysql_query($query2,$link);
            echo "<tbody>";
            while($a_rows=mysql_fetch_object($result))
            {
                $query2="select * from lesson";
                $result2=mysql_query($query2,$link);
                
                while($b_rows=mysql_fetch_object($result2))
                {
                    if($a_rows->lessonid == $b_rows->lessonid)
                    {
                        $lessonname = $b_rows->lessonname;
                        $directionid = $b_rows->direction_id;
                        $lesson_id = $b_rows->lessonid;

                            $query3="select * from course";
                            $result3=mysql_query($query3,$link);
                              while($c_rows=mysql_fetch_object($result3))
                            {
                                if($directionid == $c_rows->courseid)
                                {
                                $coursename = $c_rows->coursename;
                                }
                
                            }

                    }          
                
                }
                  $uid = $_SESSION['userid'];

                  $completeQuery = mysql_query("SELECT complete from lessoncomplete WHERE userid = $uid and lessonid = $lesson_id");
                  $completeQuery2 = mysql_query("SELECT complete from user_to_quiz WHERE userid = $uid and quizid = $a_rows->quizid");
                  if(mysql_num_rows($completeQuery2) == 0)
                  {
                       if(mysql_num_rows($completeQuery) != 0)
                        {

                         $completeResult = mysql_result($completeQuery,0);
                 
                        if($completeResult == 1)
                {
        ?>
                <tr>
                <td align="left" width="100"><?php echo $a_rows->quizid ?></a></td>
                <td align="left" width="100"><a href="questions.php?qid=<?php echo $a_rows->quizid ?>"><?php echo $a_rows->quizname ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->created ?></td>
                <td align="left" width="100"><?php echo $lessonname ?></td>
                <td align="left" width="100"><?php echo $coursename ?></td>
                </tr>                
        <?php
                }
                }
                }
                else
                {
                    $completeResult2 = mysql_result($completeQuery2,0);

                    if($completeResult2 == 1)
                {
        ?>
                <tr>
                <td align="left" width="100"><?php echo $a_rows->quizid ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->quizname ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->created ?></td>
                <td align="left" width="100"><?php echo $lessonname ?></td>
                <td align="left" width="100"><?php echo $coursename ?></td>
                </tr>                
        <?php
                }

                else
                {

                     ?>
                <tr>
                <td align="left" width="100"><?php echo $a_rows->quizid ?></a></td>
                <td align="left" width="100"><a href="questions.php?qid=<?php echo $a_rows->quizid ?>"><?php echo $a_rows->quizname ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->created ?></td>
                <td align="left" width="100"><?php echo $lessonname ?></td>
                <td align="left" width="100"><?php echo $coursename ?></td>
                </tr>                
        <?php
                }

                }

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