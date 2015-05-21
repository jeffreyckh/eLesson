<?php
session_start();
$urank = $_SESSION['rank'];
if ($urank == 3)
{
  echo '<script language="javascript">';
  echo 'alert("You have no permission to access here")';
  echo '</script>';
  
  header("Location: ../user/userHome.php");
  die();
}
include'../inc/db_config.php';
include '../inc/header.php';
 $uid = $_SESSION['userid'];
 $urank = $_SESSION['rank'];
    $query3 = " select * from user where userid = $uid";
    $result3 = mysql_query($query3);
    while($rows=mysql_fetch_object($result3))
    {
        if($rows->rank == 2)
        {
            include '../inc/normalAdminNav.php';
        }
        else
        {
           include 'adminNav.php'; 
        }
    }
$temp_id;
$query_count="select count(*) from question";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;
$quizid = intval($_REQUEST['qid']);
$query = " select * from question order by questionid DESC limit 1";
$result = mysql_query($query,$link);
 while($m_rows=mysql_fetch_object($result))
    {
        $questionid = $m_rows->questionid + 1;
    }
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
    <script type="text/javascript">
      function validateForm(){
        var q_content = tinyMCE.activeEditor.getContent();
        var q_course = document.getElementById("ques_course").value;
        var q_ans = document.getElementById("quesans").value;
        var q_option = document.getElementById("p_new");
        var q_options = document.getElementsByName("p_new[]");
        var q_option_num = q_options.length;

        var ans_count = 0;
        
        for(var i=0; i<q_option_num; i++){
          /*alert(q_options[i].value); */
          var option_ans = q_options[i].value;
          if(option_ans == q_ans){
            ans_count++;
          }
        }

        var values = "";

        /* Validation Section */
        if(q_course == ""){
          /* Validate course selection */
          alert("Please select a course.");
        }else if(q_content == ""){
          /* Validate content existence */
          alert("Please enter question content.");
          // warning_string += "Please enter question content.\n";
          return false;
        }else if(q_ans == ""){
          /* Validate answer existence */
          alert("Please enter correct answer.");
          // warning_string += "Please enter question answer.\n";
          return false;
        }else if(q_option == null){
          /* Validate option list existence */
          alert("Please enter option list.");
          // warning_string += "Please enter option list.\n";
          return false;
        }else if(ans_count<1){
          /* The correct answer cannot be found in the option list */
          alert("The correct answer is not included into the option list."
                +"\n"+"Ensure that the correct answer is in the option list.");
          return false;
        }else if(ans_count>1){
          /* The correct answer is included more than once in the option list */
          alert("The correct answer has been included into the option list more than once."
                +"\n"+"Ensure that the correct answer is only included once in the option list.");
          return false;
        }else{
          
          return true;
        }

        return false;
      }

      $(function() {
        var addDiv = $('#addinput');
        var i = $('#addinput #extra').size() + 1;
        $('#addNew').on('click', function() {
          $('<div id="extra"><input type="text" id="p_new" size="20" name="p_new[]' + 
          '" value="" placeholder="Add answer option here" /><a href="#" id="remNew"><button type="button" class="btn btn-default" title="Remove an option">' + 
          '<img src="../img/minusicon_white.png"></button></a></div>').appendTo(addDiv);
        i++;
          return false;
        });

        $(document).on('click', "#remNew", function() {
          if( i > 1 ) {
            $(this).parents('#extra').remove();
            // i--;
          }
          return false;
        });
      });

    </script>
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
<form action="?action=addquestion&qid=<?php echo $quizid?>>" name="add_question_form" method="post" onsubmit="return(validateForm())">
<table class = "table table-bordered">
<tr>
  <td>
    Course:
  </td>
  <td>
    <select id="ques_course" name="ques_course">
        <option value="" selected disabled>--- Select a Course ---</option>
        <?php
            if($urank == 2)
            {
                echo $urank;
                $select_perm = "SELECT * FROM permission WHERE userid = $uid";
                $permresult = mysql_query($select_perm);
                while($permrows = mysql_fetch_object($permresult))
                {
                    $select_course = "SELECT * FROM course WHERE courseid = '".$permrows->courseid."'";
                     $result = mysql_query($select_course);
                    while($row = mysql_fetch_object($result)){
                    ?>    
                    <option value="<?php echo $row->courseid ?>,<?php echo $row->coursename ?>"><?php echo $row->coursename ?></option>
                    <?php
                    }
                }
            }
            else
            {
               $select_course = "SELECT * FROM course";
                $result = mysql_query($select_course);
                while($row = mysql_fetch_object($result)){
                ?>
              <option value="<?php echo $row->courseid ?>,<?php echo $row->coursename ?>"><?php echo $row->coursename ?></option>
              <?php
                }

            }
            ?>
    </select>
  </td>
</tr>
<tr> 
<input type="hidden" type="text" type="hidden" id="quesid" name="quesid" value="<?php echo $questionid ?>">
<td>Question Content:</td>
<td>
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

<td>Correct Answer:</td><td><input type="text" id="quesans" name="quesans"></td></tr>
<td>Option List:</td>
<td>
  <div id="addinput">
    <a href="#" id="addNew">
      <button type="button" class="btn btn-default" title="Add Option">
        <img src="../img/addicon_white.png">
        <!-- Add -->
      </button>
    </a>
  </div>
</td>
<!-- <td><input type="text" name="option"></td> -->
</tr>
<td>Difficulty:</td><td>
    <select name="ddlDifficulty">
        <option value="Easy" selected>Easy</option>
        <option value="Normal">Normal</option>
        <option value="Hard">Hard</option>
    </select></td></tr>
</table>
<div align = "center"><input class="btn btn-default" type="submit" value="Add">&nbsp&nbsp<input class="btn btn-default" type="reset">
</form>
<script>
      tinymce.init({
    selector: "textarea",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager media youtube"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code | youtube",
   image_advtab: true ,
   external_filemanager_path:"/eLesson/jscss/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "/eLesson/jscss/filemanager/plugin.min.js"}
    
    });
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
    $add_content = htmlspecialchars($add_content);
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
    
    $add_answer = str_replace(">","&gt",$add_answer);

    // $add_option=$_POST['option'];
    // $add_option = str_replace("/","/",$add_option);
    // $add_option = str_replace("<","&lt",$add_option);
    // $add_option = str_replace(">","&gt",$add_option);

    $add_option = "";
    $p_new      = $_POST['p_new'];
    array_unshift($p_new, $add_answer);
    $size_p     = sizeof($p_new) - 1;

    for($i=0; $i<sizeof($p_new); $i++){

      $p_new[$i] = str_replace("<","&lt",$p_new[$i]);
      $p_new[$i] = str_replace(">","&gt",$p_new[$i]);
      
      $add_option .= $p_new[$i];
      if($i<$size_p){
        $add_option .= "/";
      }
    }
    
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

            $add_answer = str_replace("/","/",$add_answer);
             $add_answer = str_replace("<","&lt",$add_answer);
            $add_option = str_replace(">","&gt",$add_option);
             $add_option = str_replace("/","/",$add_option);
            $add_content = str_replace("<","&lt",$add_content);
            $add_content = str_replace(">","&gt",$add_content);
            // $sql="INSERT into question(questionid,content,choicetype,answer,optionlist,difficulty,course_id,course_name) 
            //       values('$add_questionid','$add_content','radio','$add_answer','$add_option','$add_difficulty','$c_id','$c_name')";
            $sql="INSERT into question(questionid,content,choicetype,answer,optionlist,difficulty,course_id,course_name,created_on,created_by) 
                  values('$add_questionid','$add_content','radio','$add_answer','$add_option','$add_difficulty','$c_id','$c_name','$create_time','$create_user')";
            if(!mysql_query($sql,$link)){
             die("Could not add new question.".mysql_error());
            }else
            {
                $sql2 = "INSERT into quiz_to_question(quizid,questionid) values('$add_quizid','$add_questionid')";
                 if(!mysql_query($sql2,$link)){
                  die("Could not add new question.".mysql_error());
                }
                  else
                  {
                    date_default_timezone_set("Asia/Kuching");
                    $modify_time = date('Y-m-d H:i:s');
                    $modify_user = $_SESSION['username'];
                    $last_inserted_id = mysql_insert_id();

                    // Get direction_id to update modification information of the course
                    // $query_select_question = "SELECT quizid FROM question WHERE questionid = '$add_quizid'";
                    // $select_question_result = mysql_query($query_select_question, $link);

                    // while($row = mysql_fetch_object($select_question_result)){
                    //   $quiz_id = $row->quizid;
                    // }

                    // $query_update_quiz = "UPDATE quiz SET
                    //                         modified_on = '$modify_time', modified_by = '$modify_user'
                    //                         WHERE quizid = '$quiz_id'";

                    // mysql_query($query_update_quiz, $link);
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
