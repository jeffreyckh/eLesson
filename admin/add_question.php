<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
$query_count="select count(*) from question";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;

$query = " select * from question order by questionid DESC limit 1";
$result = mysql_query($query,$link);
 while($m_rows=mysql_fetch_object($result))
    {
        $questionid = $m_rows->questionid + 1;
    }
//$quizid = intval($_REQUEST['qid']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Add Question</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/tinymce/tinymce.min.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="view_questionlist.php">Questions</a></li>
    <li class="active">Add Question</li>
    </ol>
<center>
Add Question
<hr>

<?php
if(isset($_GET['action'])=='addquestion') {
    addquestion();
}
else
//show form
?>
<table class = "table table-bordered">
<form action="?action=addquestion>" method="post">
<tr>
  <td>
    Course:
  </td>
  <td>
    <select name="ques_course">
        <option value="" selected disabled>--- Select a Course ---</option>
        <?php
        $select_course = "SELECT * FROM course";
        $result = mysql_query($select_course);
        while($row = mysql_fetch_object($result)){
          ?>
          <option value="<?php echo $row->courseid ?>,<?php echo $row->coursename ?>"><?php echo $row->coursename ?></option>
          <?php
        }
        ?>
    </select>
  </td>
</tr>
<tr>
<input type="hidden" type="text" type="hidden" name="quesid" value="<?php echo $questionid ?>">
<td>Question Content:</td><td>
    <textarea name="quescont" id="quescont" rows="10" cols="80"></textarea>
</td>
</tr>
<!-- <td>Question Type:</td>
 <td><input type="radio" name="choicetype" checked = "checked"
<?php if (isset($choicetype) && $choicetype=="radio") echo "checked";?>
value="radio">Single Choice
<input type="radio" name="choicetype"
<?php if (isset($choicetype) && $choicetype=="checkbox") echo "checked";?>
value="checkbox">Multiple Choice</td></tr>
-->

<td>Correct Answer:</td><td><input type="text" name="quesans"></td></tr>
<td>Option List(Use "/" to separate):</td><td><input type="text" name="option"></td></tr>
<td>Difficulty:</td><td>
    <select name="ddlDifficulty">
        <option value="Easy" selected>Easy</option>
        <option value="Normal">Normal</option>
        <option value="Hard">Hard</option>
    </select></td></tr>
</table>
<div align = "center"><input class="btn btn-default" type="submit" value="Add">&nbsp&nbsp<input class="btn btn-default" type="reset"></td></tr>
</form>
<script>
       tinymce.init({
    selector: "textarea",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
   image_advtab: true ,
   external_filemanager_path:"/eLesson/jscss/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "/eLesson/jscss/filemanager/plugin.min.js"}
</script>
</body>
</html>


 <?php
 function addquestion() 
 {
    include'../inc/db_config.php';
    // $add_quizid=intval($_REQUEST['qid']);
    $add_questionid=intval($_POST['quesid']);
    $add_content=$_POST['quescont'];
	//$add_type=$_POST['choicetype'];
	//$date = date('Y-m-d H:i:s');

    if(isset($_SESSION['username'])){
      $create_user = $_SESSION['username'];
    }
    date_default_timezone_set("Asia/Kuching");
    $create_time  = date("Y-m-d h:i:s");
    $modify_user  = "-";
    $modify_time  = "0000-00-00 00:00:00";
    $delete_user  = "-";
    $delete_time  = "0000-00-00 00:00:00";
    $rec_status   = "-";

    $c_details = $_POST['ques_course'];
    $c_explode = explode(',', $c_details);
    $c_id = $c_explode[0];
    $c_name = $c_explode[1];

    $add_answer=$_POST['quesans'];
    $add_answer = str_replace("/","/",$add_answer);
    $add_option=$_POST['option'];
    $add_option = str_replace("/","/",$add_option);
    $add_difficulty = $_POST['ddlDifficulty'];
	$flag=false;
	$check="select * from question";
	$check_result=mysql_query($check,$link);
		while($result_rows=mysql_fetch_object($check_result))
		{
    		if(strcmp($add_questionid,$result_rows->content)!=0 && $result_rows->questionid!=$add_questionid && $result_rows->content != $add_content)
        	$flag=false;
    		else
        	$flag=true;
		}
    
    if($flag==false)
    {
            $sql="INSERT into question(questionid,content,choicetype,answer,optionlist,difficulty,course_id,course_name) 
                  values('$add_questionid','$add_content','radio','$add_answer','$add_option','$add_difficulty','$c_id','$c_name')";
            $sql2="";                  
            
            if(!mysql_query($sql,$link)){
              // echo $sql;
             die("Could not add new question.".mysql_error());
            }else
            {

              date_default_timezone_set("Asia/Kuching");
              $modify_time = date('Y-m-d H:i:s');
              $modify_user = $_SESSION['username'];
              $last_inserted_id = mysql_insert_id();

              // Get direction_id to update modification information of the course
              $query_select_question = "SELECT quizid FROM question WHERE questionid = '$last_inserted_id'";
              $select_question_result = mysql_query($query_select_question, $link);

              while($row = mysql_fetch_object($select_question_result)){
                $quiz_id = $row->quizid;
              }

              $query_update_quiz = "UPDATE quiz SET
                                      modified_on = '$modify_time', modified_by = '$modify_user'
                                      WHERE courseid = '$quiz_id'";

              mysql_query($query_update_quiz, $link);

                echo '<script> alert("Add Question Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="view_question.php</script>';
            }
        
       
    }
    else{
        echo "Question Existed ";
    }

 }

?>

<?php

mysql_close($link);
?>
