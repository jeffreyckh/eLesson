<?php
session_start();
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
           include 'userNav.php'; 
        }
    }
require_once('../view/announcementView.php');
$announcement = new announcementView();
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
   <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
</head>
<body>
<div class = "col-md-6">
  
    <div class = "row">
      
      
        <table id = "incomplete" width = "100%" class="table table-striped table-bordered" cellspacing="0">
          <p><b>Incomplete Lesson</b></p>
        <thead>
            <th width = "30%" align="right">Course</th>
            <th align="right">Lesson</th>
        </thead>
        <?php
          $incompquery = "SELECT * FROM lessoncomplete WHERE userid = '$uid'AND complete = '0'";
          $incompresult = mysql_query($incompquery);
          echo "<tbody>";
          while($incomp_rows = mysql_fetch_object($incompresult))
          {
            $lessonid = $incomp_rows->lessonid;
            $inlesson = "SELECT *FROM lesson where lessonid = '$lessonid'";
            $lessonresult = mysql_query($inlesson) or die(mysql_error());
            while ($l_rows=mysql_fetch_object($lessonresult))
            {
              $lessonname = $l_rows->lessonname;
              $courseid = $l_rows->direction_id;
              $incourse = "SELECT * FROM course WHERE courseid = '$courseid'";
              $courseresult = mysql_query($incourse) or die(mysql_error());
              while ($c_rows = mysql_fetch_object($courseresult)) 
              {
                $coursename = $c_rows->coursename;
                ?>
                 <tr>
                    <td width = "30%" align="left"><?php echo $coursename ?></a></td>
                    <td align="left"><?php echo "
                       <a href=\"lessons_info.php?lid=$lessonid\">".$lessonname."</a>"; ?></a></td>
                </tr>
          <?php
              }
            }
          }
        ?>
      </tbody>
    </table>
    </div>
<!-- complete lesson !-->
  <div class = "row">
      <table id = "Complete" class="table table-striped table-bordered" cellspacing="0">
        <p><b>Complete Lesson</b></p>
        <thead>
            <th width = "30%" align="right">Course</th>
            <th align="right">Lesson</th>
        </thead>
        <?php
          $compquery = "SELECT * FROM lessoncomplete WHERE userid = '$uid'AND complete = '1'";
          $compresult = mysql_query($compquery);
          echo "<tbody>";
          while($comp_rows = mysql_fetch_object($compresult))
          {
            $complessonid = $comp_rows->lessonid;
            $complesson = "SELECT *FROM lesson where lessonid = '$complessonid'";
            $complessonresult = mysql_query($complesson) or die(mysql_error());
            while ($compl_rows=mysql_fetch_object($complessonresult))
            {
              $complessonname = $compl_rows->lessonname;
              $compcourseid = $compl_rows->direction_id;
              $compcourse = "SELECT * FROM course WHERE courseid = '$compcourseid'";
              $compcourseresult = mysql_query($compcourse) or die(mysql_error());
              while ($compc_rows = mysql_fetch_object($compcourseresult)) 
              {
                $compcoursename = $compc_rows->coursename;
                ?>
                 <tr>
                    <td width = "30%" align="left" ><?php echo $compcoursename ?></a></td>
                    <td align="left" ><?php echo "
                       <a href=\"lessons_info.php?lid=$complessonid\">".$complessonname."</a>"; ?></a></td>
                </tr>
          <?php
              }
            }
          }
        ?>
      </tbody>
    </table>
  </div>


 <div class = "row">
      
        <table id = "CompleteQuiz" class="table table-striped table-bordered" cellspacing="0">
          <p><b>Completed Quiz</b></p>
        <thead>
            <th align="right">Course</th>
            <th align="right">Lesson</th>
             <th align="right">Quiz</th>
        </thead>
        <?php
          $cquizquery = "SELECT * FROM user_to_quiz WHERE userid = '$uid'AND complete = '1'";
          $cquizresult = mysql_query($cquizquery);
          echo "<tbody>";
          while($cquiz_rows = mysql_fetch_object($cquizresult))
          {
            $quizid = $cquiz_rows->quizid;

            $cquiz = "SELECT * FROM quiz where quizid = '$quizid'";
            $quizresult = mysql_query($cquiz) or die(mysql_error());
            while ($q_rows=mysql_fetch_object($quizresult))
            {
              $lessonname = $q_rows->lesson_name;
              $coursename = $q_rows->course_name;
              $quizname = $q_rows->quizname;

             
                ?>
                 <tr>
                    <td align="left"><?php echo $coursename ?></a></td>
                    <td align="left"><?php echo $lessonname ?></a></td>
                    <td align="left"><?php echo "
                       <a href=\"user_viewresult.php?qid=$quizid\">".$quizname."</a>"; ?></a></td>
                </tr>
          <?php
              
            }
          }
        ?>
      </tbody>
    </table>
    </div>


</div>
  <div class = "col-md-2">
  </div>
  <div class = "col-md-2">
  <div class = "row">
  <?php
  include "../inc/calender.php";
  ?>
  <br></br>
    <div class = "row">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Announcement
            </a>
          </h4>
        </div>
      <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <fieldset class = "setright">
              <?php
                  $query="select * from announcement order by taskid DESC limit 1";
                  $result=mysql_query($query);
                  while($a_rows=mysql_fetch_object($result))
                  {
                  echo "<fieldset>
                     Posted On:".$a_rows->taskdate."
                     <br></br>
                     Annoucement:".$a_rows->taskname."
                     </fieldset>";
                  }
              ?>      
            </fieldset>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){
    $('.table').DataTable(
        { 
            "dom": '<"right"l>rt<"left"i><"right"p><"clear">',
            "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
        });
});
</script>
</body>
</html>