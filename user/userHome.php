<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'userNav.php';
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
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
  <div class = "col-md-7">
    <legend>Navigation</legend>
    <div class = "row">
      <div class = "col-md-2">
        <figure>
        <a href="courses.php"><img src="../img/blackboard.png"></a>
        <figcaption>Course</figcaption>
        </figure>
      </div>
      <div class = "col-md-2">
       <figure>
        <a href="user_viewquiz.php"><img src="../img/quiz.png"></a>
        <figcaption>Quiz</figcaption>
        </figure> 
      </div>
      <div class = "col-md-2">
        <figure>
        <a href="announcement.php"><img src="../img/announcement.png"></a>
        <figcaption>Announcement</figcaption>
        </figure>
      </div>
    </div>
    <br></br>
    <div class = "home-table">
      <table>
      </table>
      
      </ul>
    </div>
  
  </div>

  <div class = "col-md-3">
  <div class = "row">

  <?php
  include "../inc/calender.php";
  ?>
  <br></br>

    <div class = "row">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Announcement
            </a>
          </h4>
        </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
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
                    echo "<hr>";
                  }
              ?>      
            </fieldset>
        </div>
      </div>
      </div>
    </div>
  </div>

</div>
</div>

<?php
function get_latest_lesson(){
  global $link;
  $user_id = $_SESSION['userid'];
  $l_id = "";
  $select_query = "SELECT last_lesson_id FROM user WHERE userid=$user_id";
  // echo $select_query;
  // echo $_SESSION['userid'];
  $result_query = mysql_query($select_query, $link);
  while($row = mysql_fetch_object($result_query)){
    $l_id = $row->last_lesson_id;
  }

  $l_name = "";
  $select_lesson_query = "SELECT * FROM lesson WHERE lessonid=$l_id";
  $result_lesson_query = mysql_query($select_lesson_query, $link);
  while($row = mysql_fetch_object($result_lesson_query)){
    $l_name = $row->lessonname;
  }

  echo $l_name;
}
?>
</body>
</html>