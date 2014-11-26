<?php
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
$query_count="select count(*) from quiz";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;

?>
<center>
Add Quiz
<hr>

<?php
if(isset($_GET['action'])=='addquiz') {
    addquiz();
}
else
//show form
?>
<table>
<tr>
 <form action="?action=addquiz" method="post">
<td>Lesson:</td>
<td><select name="select">
     <?php $query2="select * from lesson order by direction_id";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {
    ?>
     
<option value="<?php echo $b_rows->lessonid ?>" selected><?php echo $b_rows->lessonname ?></option>

<?php
}
?>

</select></td></tr>

<td>Quiz ID:</td><td><input type="text" name="qid" value="<?php echo $count ?>"></td></tr>
<td>Quiz Name:</td><td><input type="text" name="qname"></td></tr>
<tr><td><input type="submit" value="Add"></td><td><input type="reset"></td></tr>
</form>
</table>


 <?php
 function addquiz() 
 {
    include'../inc/db_config.php';
    $add_lessonid=intval($_POST['select']);
    $add_quizid=intval($_POST['qid']);
	$add_quizname=$_POST['qname'];
	$date = date('Y-m-d H:i:s');
	$flag=true;
	$check="select * from quiz";
	$check_result=mysql_query($check,$link);
		while($result_rows=mysql_fetch_object($check_result))
		{
    		if(strcmp($add_quizid,$result_rows->quizname)!=0 && $result_rows->quizid!=$add_quizid && $result_rows->quizname != $add_quizname)
        	$flag=false;
    		else
        	$flag=true;
		}
    
    if($flag==false)
    {
            $sql="insert into quiz(quizid,quizname,created,lessonid) values('$add_quizid','$add_quizname','$date','$add_lessonid')";
            
            if(!mysql_query($sql,$link)){
             die("Could not add new quiz.".mysql_error());
            }else
            {
                echo '<script> alert("Add Quiz Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="viewquiz.php"</script>';
            }
        
       
    }
    else{
        echo "Quiz Existed ";
    }

 }

?>


<br>
<a href="viewquiz.php">Return</a>
</center> 

<?php

mysql_close($link);
?>
