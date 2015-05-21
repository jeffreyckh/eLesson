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
     $uid = $_SESSION['userid'];
    $query3 = " select * from user where userid = $uid";
    $result3 = mysql_query($query3);
    while($rows=mysql_fetch_object($result3))
    {
        if($rows->rank == 2)
        {
            include '../inc/normalAdminNav.php';
        }
        else
        {
           include 'adminNav.php'; 
        }
    }
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
      
</head>
<body>
    <?php 
    $query2 = " select * from user where userid = $uid";
    $result2 = mysql_query($query2);
    while($rows=mysql_fetch_object($result2))
    {
        if($rows->rank == 2)
        {
    ?>
    <ol class="breadcrumb">
    <li><a href="../user/userHome.php">Home</a></li>
    <li class="active">Quiz</li>
    </ol>
    <?php
        }
        else
        {
    ?>
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li class="active">Quiz</li>
    </ol>
    <?php
        }
    }
    ?>

    <center>
    <?php
        $query_count="select count(*) from quiz";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>



        <div align = "right">Total Quiz:<font color="red"><?php echo $count; ?></font>&nbsp&nbsp
            <a id="addbutton" class = "btn btn-default" href="add_quiz.php">
                <img src="../img/addquiz_white.png">
                Add Quiz
            </a>
        <hr>
        <table id="quiz" class="table table-striped table-bordered" cellspacing="0" >
        <thead>    
        <th align="left">Quiz Name</th>
        <th align="left">Created</th>
        <th align="left">Lesson</th>
        <th align="left">Course</th>
        <th align="left">Action</th>
        </thead>
        <?php
        $cidarray = array();
        $i = 0;
        if($urank == 2)
        {       
                $select_perm = "SELECT * FROM permission WHERE userid = $uid";
                $permresult = mysql_query($select_perm);
                while($permrows = mysql_fetch_object($permresult))
                {
                    
                    $courseid = $permrows->courseid;
                    $cidarray[] = $courseid;
                    $query_all_quiz     = "SELECT * FROM quiz WHERE course_id = $courseid ORDER BY lessonid";
                    //$query2="select * from course";
                    $result_all_quiz    = mysql_query($query_all_quiz,$link) or die(mysql_error());
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
                        <td align="left" width="100"><a href="view_question.php?qid=<?php echo $a_rows->quizid ?>"><?php echo $a_rows->quizname ?></a></td>
                        <td align="left" width="100"><?php echo $a_rows->created ?></td>
                        <td align="left" width="100"><?php echo $lessonname ?></td>
                        <td align="left" width="100"><?php echo $coursename ?></td>
                        <td align="left" width="100">
                            <a class="action-tooltip" href="edit_quiz.php?qid=<?php echo $a_rows->quizid ?>" title="Modify">
                                <img id="action-icon" src="../img/modifyicon2_600x600.png">
                                <!-- Modify -->
                            </a>
                            <a class="action-tooltip" href="del_quiz.php?quizid=<?php echo $a_rows->quizid ?>" title="Delete">
                                <img id="action-icon" src="../img/deleteicon2_600x600.png">
                                <!-- Delete -->
                            </a>
                        </td>
        
                        </tr> 

        <?php

                }
   
            }
            
            $squery="SELECT * FROM quiz ORDER BY lessonid";
            //$query2="select * from course";
            $sresult=mysql_query($squery,$link);
            //$result2=mysql_query($query2,$link);
            echo "<tbody>";
            while($select_rows=mysql_fetch_object($sresult))
            {
                $bsquery2="select * from lesson";
                $bsresult2=mysql_query($bsquery2,$link);
                
                while($bselect_rows=mysql_fetch_object($bsresult2))
                {
                    if($select_rows->lessonid == $bselect_rows->lessonid)
                    {
                        $lessonname = $bselect_rows->lessonname;
                        $directionid = $bselect_rows->direction_id;
                        $lesson_id = $bselect_rows->lessonid;

                            $csquery3="select * from course where courseid";
                            $csresult3=mysql_query($csquery3,$link);
                              while($cselect_rows=mysql_fetch_object($csresult3))
                            {
                                if($directionid == $cselect_rows->courseid)
                                {
                                $coursename = $cselect_rows->coursename;
                                }
                
                            }

                    }          
                
                }


                    $flag = false;
                for($i = 0;$i < count($cidarray);$i++)
                {

                        if($select_rows->course_id == $cidarray[$i])
                        {
                            $flag=true;
                        }

                }



                if($flag != true)
                {
                  $uid = $_SESSION['userid'];

                  $completeQuery = mysql_query("SELECT complete from lessoncomplete WHERE userid = $uid and lessonid = $lesson_id ");
                  $completeQuery2 = mysql_query("SELECT complete from user_to_quiz WHERE userid = $uid and quizid = $select_rows->quizid");
                  $completeQuery3 = mysql_query("SELECT courseid from lessonstatus WHERE userid = $uid") or die(mysql_error());
                  if(mysql_num_rows($completeQuery3) != 0)
                  {

                    $resultid = mysql_result($completeQuery3,0);
                  }


                  

                  if(isset($resultid) && isset($courseid))
                  {

                    if($resultid != $courseid)

                  {

                  if(mysql_num_rows($completeQuery2) == 0)
                  {
                       if(mysql_num_rows($completeQuery) != 0)
                        {

                         $completeResult = mysql_result($completeQuery,0);
                 
                        if($completeResult == 1)
                {

                

        ?>
                <tr>
                <td align="left" width="100"><a href="../user/questions.php?qid=<?php echo $select_rows->quizid ?>"><?php echo $select_rows->quizname ?></a></td>
                <td align="left" width="100"><?php echo $select_rows->created ?></td>
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
                <td align="left" width="100"><?php echo $select_rows->quizname ?></a></td>
                <td align="left" width="100"><?php echo $select_rows->created ?></td>
                <td align="left" width="100"><?php echo $lessonname ?></td>
                <td align="left" width="100"><?php echo $coursename ?></td>
                </tr>                
        <?php
                }

                else
                {

                     ?>
                <tr>
                <td align="left" width="100"><a href="../user/questions.php?qid=<?php echo $select_rows->quizid ?>"><?php echo $select_rows->quizname ?></a></td>
                <td align="left" width="100"><?php echo $select_rows->created ?></td>
                <td align="left" width="100"><?php echo $lessonname ?></td>
                <td align="left" width="100"><?php echo $coursename ?></td>
                </tr>                
        <?php
                }

                }
            }


                  }
                  
            }
        }
            
        }

    else
    {
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
                        <td align="left" width="100"><a href="view_question.php?qid=<?php echo $a_rows->quizid ?>"><?php echo $a_rows->quizname ?></a></td>
                        <td align="left" width="100"><?php echo $a_rows->created ?></td>
                        <td align="left" width="100"><?php echo $lessonname ?></td>
                        <td align="left" width="100"><?php echo $coursename ?></td>
                        <td align="left" width="100">
                            <a class="action-tooltip" href="edit_quiz.php?qid=<?php echo $a_rows->quizid ?>" title="Modify">
                                <img id="action-icon" src="../img/modifyicon2_600x600.png">
                                <!-- Modify -->
                            </a>
                            <a class="action-tooltip" href="del_quiz.php?quizid=<?php echo $a_rows->quizid ?>" title="Delete">
                                <img id="action-icon" src="../img/deleteicon2_600x600.png">
                                <!-- Delete -->
                            </a>
                        </td>
        
                        </tr>                
        <?php

                    }
    }
                mysql_close($link);
        ?>  
    </tbody> 
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
        $('#quiz').DataTable(
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