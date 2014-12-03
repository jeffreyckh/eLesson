 <?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
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
  <title>Select Question</title>
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
    <li class="active">Select Question</li>
    </ol>
<center>
Select Question
<hr>

<?php
if(isset($_GET['action'])=='selectquestion') {
    selectquestion();
}
else
//show form
?>
<table class = "table table-bordered">
<tr>
 <form action="?action=selectquestion&qid=<?php echo $quizid?>" method="post">


 	<td>Question:</td>
<td><select name="questionselect">
     <?php $query2="select * from question ";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {
    ?>
     
<option value="<?php echo $b_rows->questionid ?>" selected><?php echo $b_rows->content ?></option>

<?php
}
?>

 <?php 
 /**$i = 0;
 $query2="select * from question ";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {  
    ?>
     
<input type="radio" name="radioselection<?php echo $i?>"
                    <?php 
                    if (isset($radioselection{$i}) && $radioselection{$i}=="$b_rows->content") 
                    	
                    	{
                    		echo "checked" ;	

                    	$sql="insert into quiz_to_question(quizid,questionid) values('$quizid','$b_rows->questionid')";
            
            			if(!mysql_query($sql,$link)){
             			die("Could not select the question.".mysql_error());
            			}

                    	}
                    ?>
                    value=<?php echo $b_rows->content ?> ><?php echo $b_rows->content?>
                </br>

<?php
$i++;
}
**/
?>

</table>
<div align = "center"><input class="btn btn-default" type="submit" value="Add">&nbsp&nbsp<input class="btn btn-default" type="reset"></td></tr>
</form>
<script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace( 'quescont' );
</script>
</body>
</html>


 <?php
 function selectquestion() 
 {
    include'../inc/db_config.php';
    $add_quizid=intval($_REQUEST['qid']);
    $add_questionid=intval($_POST['questionselect']);
	$flag=false;
	$check="select * from quiz_to_question where quizid=$add_quizid";
	$check_result=mysql_query($check,$link);
		while($result_rows=mysql_fetch_object($check_result))
		{
    		if(strcmp($add_questionid,$result_rows->questionid)!=0)
        	$flag=false;
    		else
        	$flag=true;
		}
    
    if($flag==false)
    {
            $sql="insert into quiz_to_question(quizid,questionid) values('$add_quizid','$add_questionid')";
            
            if(!mysql_query($sql,$link)){
             die("Could not select the question.".mysql_error());
            }else
            {
                echo '<script> alert("Select Question Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="view_question.php?qid='.$add_quizid.'"</script>';
            }
        
       
    }
    else{
        echo "Question exsited in this quiz";
    }

 }

?>

<?php

mysql_close($link);
?>


