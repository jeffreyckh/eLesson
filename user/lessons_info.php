<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    $m_id=intval($_REQUEST['lid']);
    $uid = $_SESSION['userid'];
    $vquery = " select * from user_to_lesson where userid = $uid and lessonid = $m_id";
    $vresult = mysql_query($vquery);
    $numrows = mysql_num_rows($vresult);
    //echo $numrows;
    while($v_rows = mysql_fetch_object($vresult))
    {
      $validuid = $v_rows->userid;
      $validlid = $v_rows->lessonid;
    }
    if(empty($validlid) && empty($validuid))
    {
      $uquery = "INSERT INTO user_to_lesson( userid, lessonid) 
            VALUES ('$uid', '$m_id')";
      $uresult = mysql_query($uquery);
    }
        

    $uquery = "INSERT INTO user_to_lesson( userid, lessonid) 
    VALUES ('$uid', '$m_id')";
    $uresult = mysql_query($uquery);
    $query="select lessonname,lessoncontent,direction_id from lesson where lessonid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
      $m_lessonname=$m_rows->lessonname;
      $m_lessoncontent=$m_rows->lessoncontent;
      $courseid = $m_rows->direction_id;
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="lesson">
  <meta name="description" content="lessons content">
  <title>Course Info</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
  <ol class="breadcrumb">
    <li><a href="userHome.php">Home</a></li>
    <li><a href="courses.php">Courses</a></li>
    <li><a href="courses_info.php?cid=<?php echo $courseid?>">Course Info</a></li>
    <li class="active">Lesson Info</li>
    </ol>

<div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#lessonDetail" aria-controls="lessonDetail" role="tab" data-toggle="tab">Lesson Content</a></li>
    <li role="presentation"><a href="#quiz" aria-controls="quiz" role="tab" data-toggle="tab">Quiz</a></li>  
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="lessonDetail">
          <h1>Lesson Name:<?php echo $m_lessonname ?></h1>
          <hr>
          <h2>Lesson Content:</h2>
            <fieldset><?php echo $m_lessoncontent ?></fieldset>    


            <?php
        if(isset($_GET['action'])=='donelesson') {
            donelesson();
          }else
          //show form
          ?>

          <table class = "table table-bordered">
          <tr>
          <form action="?action=donelesson" method="post">
          <input type="hidden" type="text" name="cid" value="<?php echo $courseid ?>">
          <input type="hidden" type="text" name="lid" value="<?php echo $m_id ?>">
          </table>
          <?php 
        
           $querycheck = "select lessoncount from lessonstatus where userid = $uid and courseid = $courseid";
           $checkresult = mysql_query($querycheck);
           $currentcount = mysql_result($checkresult,0);
           $current_query = "select lessonid from lesson where direction_id = $courseid limit $currentcount";
           $current_result= mysql_query($current_query);
           $current_lesson = mysql_result($current_result,($currentcount - 1));

            if($m_id == $current_lesson)
            {

            ?>
          
          <div align = "center" ><input class="btn btn-default" type="submit" value="Complete"></div>
            <?php 

           
          } 
            
            ?>
          </form>
        </div>

  <div role="tabpanel" class="tab-pane" id="quiz">
    <?php
        $l_id=intval($_REQUEST['lid']);
        $query_count="select count(*) from quiz where lessonid=$l_id";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
        ?>
        <table id = "quiz" class="table table-striped table-bordered" cellspacing="0">
        <thead>
            <tr>
            <th align="left">Quiz ID</th>
            <th align="left">Quiz Name</th>
            <th align="left">Created</th>
            </tr>
            </thead>
        <?php
            $qquery="select * from quiz where lessonid=$l_id";
            $qresult=mysql_query($qquery,$link);
            echo "<tbody>";
            while($a_rows=mysql_fetch_object($qresult))
            {
        ?>
        <tr>
            <td align="left" width="100"><?php echo $a_rows->quizid ?></a></td>
            <td align="left" width="100"><a href="questions.php?qid=<?php echo $a_rows->quizid ?>"><?php echo $a_rows->quizname ?></a></td>
            <td align="left" width="100"><?php echo $a_rows->created ?></td>
        </tr>
        <?php
        }

         // mysql_close($link);
        ?>  
        </tbody> 
        </td>
        </tr>
        </table>

    </div>
</div> 

 
    <?php
        }
        mysql_close($link);
        ?>  
<script>
$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
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


  <?php

           function donelesson() 
          {

          include'../inc/db_config.php';
           $done_courseid=intval($_POST['cid']);
           $done_lessonid=intval($_POST['lid']);
            $uid = $_SESSION['userid'];
          $date = date('Y-m-d H:i:s');
          $flag=true;
         $done_query="SELECT lessoncount FROM lessonstatus WHERE userid = $uid AND courseid = $done_courseid";
          $done_result=mysql_query($done_query,$link);
         

          $newlc = mysql_result($done_result,0) + 1;


          //$sql = "UPDATE lessonstatus SET lessoncount = $newlc WHERE userid = $uid AND courseid = $done_courseid";

           //if(!mysql_query($sql,$link))
           // { die("Could not update the data!".mysql_error());}
          //  else
           // {
                echo '<script> alert("You have finish reading the lesson! You will be direct to the quiz page.") </script>';
                echo '<script language="JavaScript"> window.location.href ="questions.php?qid='. $done_lessonid . '" </script>';
                
          //  }

          }
          ?>


