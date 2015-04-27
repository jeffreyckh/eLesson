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
  <title>Home</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#content" aria-controls="question_content" role="tab" data-toggle="tab">Question Content</a></li>
            <li role="presentation"><a href="#information" aria-controls="lessons" role="tab" data-toggle="tab">Information</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="content">
            <center>
            <?php
            $quid   = intval($_GET['quid']);
            $qid    = intval($_GET['qid']);
            $query  = "SELECT * FROM question WHERE questionid = $quid";
            $result = mysql_query($query,$link);

            $creator        = "";
            $create_time    = "";
            $modifier       = "";
            $modify_time    = "";

            while($a_rows=mysql_fetch_object($result)){
            ?>
                <table class="table table-bordered">
                    <tr>
                        <td>Current Question:</td>
                        <td>
                            <?php echo $a_rows->content ?>
                        </td>
                    </tr>
                   <!-- <tr>
                        <td>
                            Choice Type:
                        </td>
                        <td>
                            <?php 
                            // if($a_rows->choicetype == 'radio')
                            //     {$choicetype = 'Single Choice';}
                            // else
                            //     {$choicetype = 'Multiple Choice';}
                            // echo $choicetype
                            ?>
                        </td> 
                    </tr> -->
                    <tr>
                        <td>Option List:</td>
                        <td>
                            <?php 
                            $optionstring = $a_rows->optionlist;
                            $optiontoken = strtok($optionstring, "/");

                            while ($optiontoken !== false){
                                echo "$optiontoken<br>";
                                $optiontoken = strtok("/");
                            } 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Answer:</td>
                        <td>
                            <?php 
                            $answerstring = $a_rows->answer;
                            $token = strtok($answerstring,"/");

                            while ($token !== false){
                                echo "$token<br>";
                                $token = strtok("/");
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>


        <?php
            $creator        = $a_rows->created_by;
            $create_time    = $a_rows->created_on;
            $modifier       = $a_rows->modified_by;
            $modify_time    = $a_rows->modified_on;    
        }
                
        
        ?>
            <div role="tabpanel" class="tab-pane" id="information">
                <?php
                $quiz_name      = "";
                $lesson_name    = "";
                $course_name    = "";

                $query_select_quiz = "SELECT quizname, lessonid FROM quiz WHERE quizid='$qid'";
                $result_select_quiz = mysql_query($query_select_quiz, $link);

                while($q_row = mysql_fetch_object($result_select_quiz)){
                    $quiz_name  = $q_row->quizname;
                    $lid        = $q_row->lessonid;
                    $query_select_lesson = "SELECT lessonname, direction_id 
                                            FROM lesson WHERE lessonid='$lid'";
                    $result_select_lesson = mysql_query($query_select_lesson, $link);

                    while($l_row = mysql_fetch_object($result_select_lesson)){
                        $lesson_name    = $l_row->lessonname;
                        $cid            = $l_row->direction_id;
                        $query_select_course = "SELECT coursename 
                                                FROM course WHERE courseid='$cid'";
                        $result_select_course = mysql_query($query_select_course, $link);

<<<<<<< HEAD
                while ($token !== false)
                {
                echo "$token<br>";
                $token = strtok("/");
                } 
                ?></td>
            </tr>
            <tr>
                <td>Difficulty:</td><td><?php
                $diff = $a_rows->difficulty;
                echo $diff ?></td>
            </tr>
            </table>
=======
                        while($c_row = mysql_fetch_object($result_select_course)){
                            $course_name = $c_row->coursename;
                        }
                    }
                }
                
                mysql_close($link);
                ?>
                <table class="table table-bordered">
                    <tr><th colspan="2">Question Information</th></tr>
                    <tr>
                        <td>Quiz:</td>
                        <td><?php echo $quiz_name ?></td>
                    </tr>
                    <tr>
                        <td>Lesson:</td>
                        <td><?php echo $lesson_name ?></td>
                    </tr>
                    <tr>
                        <td>Course:</td>
                        <td><?php echo $course_name ?></td>
                    </tr>
                    <tr>
                        <td>Created By:</td>
                        <td><?php echo $creator ?></td>
                    </tr>
                    <tr>
                        <td>Created On:</td>
                        <td><?php echo $create_time ?></td>
                    </tr>
                    <tr>
                        <td>Last Modified By:</td>
                        <td><?php echo $modifier ?></td>
                    </tr>
                    <tr>
                        <td>Last Modified On:</td>
                        <td><?php echo $modify_time ?></td>
                    </tr>
                </table>
            </div>
>>>>>>> origin/Brennan
        
               
        </center>
        
    </div>
    <tr>
        <br>
        <td align="right" colspan="6">
            <br>
            <a href="view_question.php?qid=<?php echo $qid?>">Return</a>
        </td>        
    </tr> 
    </body>
    </html>