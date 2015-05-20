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
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        getLessons();
    });
    function generate_lesson(){
        var coursedetail = document.getElementById("quiz_course").value;
        
        var arr_course = coursedetail.split(",");
        var courseid = arr_course[0];
        var coursename = arr_course[1];
        alert("Course id: "+courseid+" Course name: "+coursename);

        <?php
        // $sel_query = "SELECT * FROM course where courseid=";
        ?>
    }

    function getLessons(course_det){
        get_lesson_url = "get_lesson.php";
        var c_id = "";
        if(course_det){
            // alert("If: "+course_det);
            course_det = course_det.split(",");
            c_id = course_det[0];
            // alert("c_id: "+c_id);
            get_lesson_url += "?c_id=" + c_id;
            // alert(get_lesson_url);
        }else{
            // alert("Else: "+course_det);
        }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("sel_lesson").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", get_lesson_url, true);
        xmlhttp.send();
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
<form name="quizform" action="?action=addquiz" method="post">
<table class="table table-bordered">
<tr>
    <td>
        Course:
      </td>
      <td>
        <select name="quiz_course" id="quiz_course" onchange="getLessons(this.value)">
            <option value="" selected disabled>--- Select a Course ---</option>
            <?php
            if($urank == 2)
            {
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
    <td>Lesson:</td>
    <td>
        <!-- <select name="select">
         <?php $query2="select * from lesson order by direction_id";
                    $result2=mysql_query($query2,$link);
                    while($b_rows=mysql_fetch_object($result2))
                    {
        ?>         
        <option value="<?php echo $b_rows->lessonid ?>" selected><?php echo $b_rows->lessonname ?></option>
        <?php
        }
        ?>
        </select> -->
        <!-- <select name = "sel_lesson" id = "sel_lesson" value="<?php echo $sel_lesson; ?>">
            <option value='' disabled selected> --- Select a Lesson --- </option>
        </select> -->
        <select name = "sel_lesson" id = "sel_lesson">
            
        </select>
    </td>
</tr>

<input type="hidden" type="text" type="hidden" name="qid" value="<?php echo $quizid ?>">

<tr>
    <td>Quiz Name:</td>
    <td><input type="text" name="qname"></td>
</tr>
<tr>
    <td>Passing Score:</td>
    <td><input type="text" name="pScore"></td>
</tr>
<tr>
    <td>Numbers of Question:</td>
    <td><input type="text" name="NoQ"></td>
</tr>
</table>
<div align = "center" >
    <input  class="btn btn-default" type="submit" value="Add">
    &nbsp&nbsp
    <input  class="btn btn-default" type="reset">
</div>
</form>
</body>
</html>


 <?php
 function addquiz() 
 {
    include'../inc/db_config.php';
    $c_details = $_POST['quiz_course'];
    $c_explode = explode(',', $c_details);
    $c_id = $c_explode[0];
    $c_name = $c_explode[1];
    
    $l_details = $_POST['sel_lesson'];
    $l_explode = explode(',', $l_details);
    $l_id = $l_explode[0];
    $l_name = $l_explode[1];
    
    // $add_lessonid=intval($_POST['sel_lesson']);
    $add_quizid=intval($_POST['qid']);
    $add_quizname=$_POST['qname'];
    $add_quizScore = $_POST['pScore'];
    $add_NoQ = $_POST['NoQ'];
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
            // $sql="insert into quiz(quizid,quizname,created,lessonid) values('$add_quizid','$add_quizname','$date','$add_lessonid')";
            $sql="INSERT into quiz(quizid,quizname,created,lessonid,lesson_name,course_id,course_name,passingscore,quiz_number) 
                    values('$add_quizid','$add_quizname','$date','$l_id','$l_name','$c_id','$c_name','$add_quizScore','$add_NoQ')";
            
            if(!mysql_query($sql,$link)){
                echo $sql;
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
