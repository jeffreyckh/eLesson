 <?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
$query_count    = "SELECT count(*) from question";
$result_count   = mysql_query($query_count,$link);
$count          = mysql_result($result_count,0) + 1;
$quizid         = intval($_REQUEST['qid']);

$query_quiz = "SELECT * FROM quiz where quizid=$quizid";
$result = mysql_query($query_quiz, $link);
while($row = mysql_fetch_object($result)){
    $q_courseid = $row->course_id;
    $q_coursename = $row->course_name;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Select Question</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
    <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>   
    <script type="text/javascript">
    $(document).ready(function(){
    $('#question').DataTable(
        {     
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">',
            "columns":[
            {"name":"&nbsp;Select All", "orderable":false},
            {"name":"Difficulty", "orderable":true},
            {"name":"Question", "orderable":true},
            ],
            "order": [],
            "columnDefs":[{
                "targets": "no-sort", 
                "orderable":false
            }]
        });
    });
    function select_all(p_param){
        // alert("checking");
        checkboxes = document.getElementsByName("chk_ques[]");
        for(var i=0; i<(checkboxes.length); i++){
            // alert(checkboxes[i]);
            checkboxes[i].checked = p_param.checked;
        }

        if(this.checked){

        }
    }
    </script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="viewquiz.php">Quiz</a></li>
    <li><a href="view_question.php?qid=<?php echo $quizid?>">Questions</a></li>
    <li class="active">Select Question</li>
    </ol>
<center>Select Question</center>
<hr>
    Course: <?php echo $q_coursename ?>
<hr>

<?php
if(isset($_GET['action'])=='selectquestion') {
    selectquestion();
}
else
//show form
?>
<form action="?action=selectquestion&qid=<?php echo $quizid?>" method="post">

<table id = "question" class="table table-striped table-bordered" cellspacing="0">
    <thead>
        <th class="no-sort" align="center" width="10%"><div align = "center">
            <input type="checkbox" onclick="select_all(this)">&nbsp;Select All
        </th>
        <th align="center" width="10%"><div align = "center">Difficulty</th>
        <th align="center"><div align = "center">Question</th>
    </thead>


    <?php
        $query2="SELECT * from question where course_id=$q_courseid";
        $result2=mysql_query($query2,$link);

        $arr_quesid = array();
        $query_qtq = "SELECT * FROM quiz_to_question where quizid=$quizid";
        $result3 = mysql_query($query_qtq, $link);
        while($row = mysql_fetch_object($result3)){
            array_push($arr_quesid, $row->questionid);
        }
        // print_r($arr_quesid);

        while($b_rows=mysql_fetch_object($result2))
        {
            $check_flag = false;
            if(in_array($b_rows->questionid, $arr_quesid)){
                $check_flag = true;
            }
    ?>
            <tr>
                <td>
                    <div align = "center">
                    <input type="checkbox" id="chk_ques" 
                        name="chk_ques[]" value="<?php echo $b_rows->questionid ?>"
                        <?php echo ($check_flag==true ? 'checked' : '') ?>>
                    </td>
                <td><div align = "center"><?php echo $b_rows->difficulty ?></td>
                <td><?php echo $b_rows->content ?></td>
            </tr>
    <?php
        }
    ?>

</table>

<div align = "center">
    <input class="btn btn-default" type="submit" value="Add">
    &nbsp&nbsp
    <input class="btn btn-default" type="reset">
    <!-- <button class="btn btn-default" type="button">Select All</button> -->
</td>
</tr>
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
    include '../inc/db_config.php';
    $add_quizid     = intval($_REQUEST['qid']);
    
    // $add_questionid = intval($_POST['questionselect']);



	$flag  = false;
	$check = "SELECT * from quiz_to_question where quizid=$add_quizid";
	$check_result  = mysql_query($check,$link);
		while($result_rows=mysql_fetch_object($check_result))
		{
    		if(strcmp($add_questionid,$result_rows->questionid)!=0)
        	$flag=false;
    		else
        	$flag=true;
		}
    
    if($flag==false)
    {
        $delete = "DELETE from quiz_to_question WHERE quizid=$add_quizid";
        mysql_query($delete);

        if(isset($_POST['chk_ques'])){

            $insert_query = "INSERT into quiz_to_question(quizid, questionid) VALUES";
            foreach($_POST['chk_ques'] as $selected){
                // echo $selected."<br>";

                $insert_query .= "('$add_quizid', '$selected'),";
                                    // echo $insert_query."<br>";
            }
            
            $insert_query = chop($insert_query, ",");
            
        }
            // $sql="INSERT into quiz_to_question(quizid,questionid) 
            //         values('$add_quizid','$add_questionid')";
            
            if(!mysql_query($insert_query,$link)){
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


