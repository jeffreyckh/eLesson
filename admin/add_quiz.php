<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
$query_count="select count(*) from quiz";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Add Quiz</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        function validateForm(){
            if(document.add_quiz_form.qname.value == ""){
                alert("Please enter a quiz name.");
                return false;
            }else{
                return true;
            }

            return false;
        }
    </script>
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
<<<<<<< HEAD
 <form action="?action=addquiz" name="add_quiz_form" method="post" onsubmit="return(validateForm())">
=======
<form action="?action=addquiz" method="post">
>>>>>>> origin/Brennan
<td>Lesson:</td>
<td><select name="select">
    <?php

    $query_all_lesson   = "SELECT * FROM lesson ORDER BY direction_id";  
    $result_all_lesson  = mysql_query($query_all_lesson, $link);
    while($b_rows=mysql_fetch_object($result_all_lesson)){

    ?>
     
<option value="<?php echo $b_rows->lessonid ?>" selected><?php echo $b_rows->lessonname ?></option>

<?php
}
?>

</select></td></tr>

<td>Quiz ID:</td><td><input type="text" name="qid" value="<?php echo $count ?>"></td></tr>
<td>Quiz Name:</td><td><input type="text" name="qname"></td></tr>
</table>
<div align = "center" ><input  class="btn btn-default" type="submit" value="Add">&nbsp&nbsp<input  class="btn btn-default" type="reset"></div>
</form>
</body>
</html>


 <?php
 function addquiz() 
 {
    include '../inc/db_config.php';
    $add_lessonid  = intval($_POST['select']);
    $add_quizid    = intval($_POST['qid']);
	$add_quizname  = $_POST['qname'];

    $create_user = "-";
        if(isset($_SESSION['username'])){
            $create_user = $_SESSION['username'];
        }

	$date          = date('Y-m-d H:i:s');
    date_default_timezone_set("Asia/Kuching");
    $create_time  = date("Y-m-d h:i:s");
    $modify_user  = "-";
    $modify_time  = "0000-00-00 00:00:00";
    $delete_user  = "-";
    $delete_time  = "0000-00-00 00:00:00";
    $rec_status   = "-";

	$flag          = true;
	$check         = "SELECT * FROM quiz";
	$check_result  = mysql_query($check,$link);
		while($result_rows = mysql_fetch_object($check_result))
		{
    		if(strcmp($add_quizid, $result_rows->quizname)!=0 && 
                $result_rows->quizid != $add_quizid && 
                $result_rows->quizname != $add_quizname)
        	   $flag = false;
    		else
        	   $flag = true;
		}
    
    if($flag==false)
    {
            $sql = "insert into quiz(quizid,quizname,created,lessonid) values('$add_quizid','$add_quizname','$date','$add_lessonid')";
            $query_insert_quiz = "INSERT INTO quiz
                                    ( quizid, quizname, created, lessonid,
                                      created_on, created_by, modified_on, modified_by, 
                                      deleted_on, deleted_by, rec_status )
                                    VALUES
                                    ( '$add_quizid', '$add_quizname', '$date', '$add_lessonid',
                                      '$create_time', '$create_user',
                                      '$modify_time', '$modify_user',
                                      '$delete_time', '$delete_user',
                                      '$rec_status' )";
            if(!mysql_query($query_insert_quiz,$link)){
             die("Could not add new quiz.".mysql_error());
            }else
            {
                echo '<script> alert("Add Quiz Successful!") </script>';
                echo $query_insert_quiz;
                echo '<script language="JavaScript"> window.location.href ="viewquiz.php"</script>';
            }
        
       
    }
    else{
        echo "Quiz Existed ";
    }

 }

?>


<?php

mysql_close($link);
?>
