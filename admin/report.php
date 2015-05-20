<?php
session_start();
$urank = $_SESSION['rank'];
if ($urank == 3 || $urank ==2)
{
  echo '<script language="javascript">';
  echo 'alert("You have no permission to access here")';
  echo '</script>';
  
  header("Location: ../user/userHome.php");
  die();
}
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
  <title>Report</title>
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <!--Script required for Google chart !-->
    <script type="text/javascript" src="../jscss/googleChart.js"></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="../jscss/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="../jscss/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <link rel="stylesheet" href="../jscss/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <link rel="stylesheet" href="../jscss/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script language="javascript">
function printdiv(printpage){
	var headstr="<html><head><title></title></head><body>";
	var footstr="</body>";
	var newstr=document.all.item(printpage).innerHTML;
	var oldstr=document.body.innerHTML;
	document.body.innerHTML=headstr+newstr+footstr;
	window.print(); 
	document.body.innerHTML=oldstr;
	return false;
}
</script>


<script>
$(document).ready(function(){
    $('.table').DataTable(
        { 
            "dom": '<"right"l>rt<"left"i><"right"p><"clear">',
            "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
        });
});
</script>
   <body>
   	<ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li class="active">Report</li>
    </ol>

 	<input type="button" class = "btn btn-default" onClick="printdiv('div_print');" value="Print">
	<div id="div_print">
		<div class = "row">
      	<table id = "LessonStatus" class="table table-striped table-bordered" cellspacing="0">
          <h4><b>Lesson Status</b></h4>
        <thead>
            <th align="right">User</th>
            <th align="right">Lesson Name</th>
            <th align="right">Start Time</th>
            <th align="right">Complete Time</th>
        </thead>
        <?php
          $CLquery = "SELECT * FROM lessoncomplete";
          $CLresult = mysql_query($CLquery);
          echo "<tbody>";
          while($CLrows = mysql_fetch_object($CLresult))
          {
           
            $UNresult = mysql_query("SELECT username FROM user WHERE userid = $CLrows->userid") or die(mysql_error());
            $LNresult = mysql_query("SELECT lessonname FROM lesson WHERE lessonid = $CLrows->lessonid") or die(mysql_error());
            $username = mysql_result($UNresult,0);
            $lessonname = mysql_result($LNresult,0);

        ?>
                 <tr>
                    <td align="left"><?php echo $username ?></a></td>
                    <td align="left"><?php echo $lessonname ?></a></td>
                    <td align="left"><?php echo $CLrows->start_time ?></a></td>
                    <td align="left"><?php echo $CLrows->end_time ?></a></td>
                </tr>
        <?php   
          }
        ?>
     	</tbody>
   		</table>
    	</div>
	</div>


	 	<input type="button" class = "btn btn-default" onClick="printdiv('div_print2');" value="Print">
		<div id="div_print2">
		<div class = "row">
      	<table id = "QuizStatus" class="table table-striped table-bordered" cellspacing="0">
          <h4><b>Quiz Status</b></h4>
        <thead>
            <th align="right">User</th>
            <th align="right">Quiz Name</th>
            <th align="right">Lesson Name</th>
            <th align="right">Result</th>
            <th align="right">Start Time</th>
            <th align="right">Complete Time</th>
            <th align="right">Attempt Time</th>

        </thead>
        <?php
          $QSquery = "SELECT * FROM user_to_quiz";
          $QSresult = mysql_query($QSquery);
          echo "<tbody>";
          while($QSrows = mysql_fetch_object($QSresult))
          {
           	$LIresult = mysql_query("SELECT lessonid FROM quiz WHERE quizid = $QSrows->quizid") or die(mysql_error());
           	$lessonid = mysql_result($LIresult,0);
           	$LNresult2 = mysql_query("SELECT lessonname FROM lesson WHERE lessonid = $lessonid") or die(mysql_error());
            $UNresult2 = mysql_query("SELECT username FROM user WHERE userid = $QSrows->userid") or die(mysql_error());
            $QNresult = mysql_query("SELECT quizname FROM quiz WHERE quizid = $QSrows->quizid") or die(mysql_error());
            $PRresult = mysql_query("SELECT result FROM passingrate WHERE quizid = $QSrows->quizid AND userid = $QSrows->userid") or die(mysql_error());
            $username = mysql_result($UNresult2,0);
            $quizname = mysql_result($QNresult,0);
            $quizresult = mysql_result($PRresult,0);
            $lessonname = mysql_result($LNresult2,0);

        ?>
                 <tr>
                    <td align="left"><?php echo $username ?></a></td>
                    <td align="left"><?php echo $quizname ?></a></td>
                    <td align="left"><?php echo $lessonname ?></a></td>
                    <td align="left"><?php echo $quizresult ?></a></td>
                    <td align="left"><?php echo $QSrows->start_time ?></a></td>
                    <td align="left"><?php echo $QSrows->finish_time ?></a></td>
                    <td align="left"><?php echo $QSrows->attempt ?></a></td>
                   
                </tr>
        <?php   
          }
        ?>
     	</tbody>
   		</table>
    	</div>
	</div>


</body>
</html>

