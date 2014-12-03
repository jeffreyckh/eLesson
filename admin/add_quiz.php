<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
//include 'adminNav.php';
$temp_id;
$query_count="select count(*) from quiz";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;
$query = " select * from quiz order by quizid DESC limit 1";
$result = mysql_query($query,$link);
 while($m_rows=mysql_fetch_object($result))
    {
        $quizid = $m_rows->quizid + 1;
    }
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Add Quiz</title>
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
    <li class="active">Add Quiz</li>
    </ol>

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
<table class="table table-bordered">
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

<input type="hidden" type="text" type="hidden" name="qid" value="<?php echo $quizid ?>">

<td>Quiz Name:</td><td><input type="text" name="qname"></td></tr>
</table>
<div align = "center" ><input  class="btn btn-default" type="submit" value="Add">&nbsp&nbsp<input  class="btn btn-default" type="reset"></div>
</form>
</body>
</html>


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
		/*while($result_rows=mysql_fetch_object($check_result))
		{
    		if(strcmp($add_quizid,$result_rows->quizid)!=0 && $result_rows->quizid!=$add_quizid && $result_rows->quizname != $add_quizname)
        	$flag=false;
    		else
        	$flag=true;
		}
    
    if($flag==false)
    {*/
            $sql="insert into quiz(quizid,quizname,created,lessonid) values('$add_quizid','$add_quizname','$date','$add_lessonid')";
            
            if(!mysql_query($sql,$link)){
             die("Could not add new quiz.".mysql_error());
            }else
            {
                echo '<script> alert("Add Quiz Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="viewquiz.php"</script>';
            }
        
       
    //}
    //else{
    //    echo "Quiz Existed ";
    //}

 }

?>


<?php

mysql_close($link);
?>
