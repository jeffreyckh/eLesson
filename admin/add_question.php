<?php
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
$query_count="select count(*) from question";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;
$quizid = intval($_REQUEST['qid']);
?>
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
<table>
<tr>
 <form action="?action=addquestion&qid=<?php echo $quizid?>" method="post">

<td>Question ID:</td><td><input type="text" name="quesid" value="<?php echo $count ?>"></td></tr>
<td>Question Content:</td><td><input type="text" name="quescont"></td></tr>
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

<tr><td><input type="submit" value="Add"></td><td><input type="reset"></td></tr>
</form>
</table>


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
            $sql="insert into question(questionid,quizid,content,choicetype,answer,optionlist) values('$add_questionid','$add_quizid','$add_content','radio','$add_answer','$add_option')";
            
            if(!mysql_query($sql,$link)){
             die("Could not add new question.".mysql_error());
            }else
            {
                echo '<script> alert("Add Question Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="view_question.php?qid='.$add_quizid.'"</script>';
            }
        
       
    }
    else{
        echo "Question Existed ";
    }

 }

?>


<br>
<a href="view_question.php?qid=<?php echo $quizid?>">Return</a>
</center> 

<?php

mysql_close($link);
?>
