<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    $m_id=intval($_GET['lid']);
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
            <td align="left" width="100"><a href="user_doquiz.php?qid=<?php echo $a_rows->quizid ?>"><?php echo $a_rows->quizname ?></a></td>
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