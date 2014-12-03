<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
//include 'adminNav.php';
$temp_id;
$query_count="select count(*) from question";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;
$quizid = intval($_REQUEST['qid']);
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
     <li><a href="viewquiz.php">Quiz</a></li>
    <li><a href="view_question.php?qid=<?php echo $quizid?>">Questions</a></li>
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
<tr>
 <form action="?action=addquestion&qid=<?php echo $quizid?>>" method="post">
<input type="hidden" type="text" type="hidden" name="quesid" value="<?php echo $count ?>">
<td>Question Content:</td><td>
    <textarea name="quescont" id="quescont" rows="10" cols="80"></textarea>
</td></tr>
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
</table>
<div align = "center"><input class="btn btn-default" type="submit" value="Add">&nbsp&nbsp<input class="btn btn-default" type="reset">
</form>
<script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace( 'quescont' );
</script>
</body>
</html>


 <?php
 function addquestion() 
 {
    include'../inc/db_config.php';
    $add_quizid=intval($_REQUEST['qid']);
    $add_questionid=intval($_POST['quesid']);
    $add_content=$_POST['quescont'];
	//$add_type=$_POST['choicetype'];
	//$date = date('Y-m-d H:i:s');
    $add_answer=$_POST['quesans'];
    $add_answer = str_replace("/","/",$add_answer);
    $add_option=$_POST['option'];
    $add_option = str_replace("/","/",$add_option);
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
            $sql="insert into question(questionid,content,choicetype,answer,optionlist) values('$add_questionid','$add_content','radio','$add_answer','$add_option')";
            
            if(!mysql_query($sql,$link)){
             die("Could not add new question.".mysql_error());
            }else
            {
                $sql = "insert into quiz_to_question(quizid,questionid) values('$add_quizid','$add_questionid')";
                 if(!mysql_query($sql,$link)){
                  die("Could not add new question.".mysql_error());
                }
                  else
                  {
                echo '<script> alert("Add Question Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="view_question.php?qid= '. $add_quizid . '" </script>';}
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
