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
include 'adminNav.php';
$temp_id;
$query_count="select count(*) from course";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Home</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
      function validate(){

        if(document.add_course_form.cname.value == ""){
          alert("Please enter a course name.");
          return false;
        }else{
          var c_name = document.add_course_form.cname.value;
          // alert("Checking..."+l_name);
          var state = checkCourseName(c_name);
          /*alert("State: "+state);*/
          return false;
        }

        return false;
      }

      function checkCourseName(c_name){
        $.ajax({
          url: "check_course.php",
          type: "POST",
          data: "c_name=" + c_name,
          success: function(data){
            // alert(data);
            if(data == 1){
              $("#name_warning_msg").html("Course name is taken, choose another.");
              // return false;
            }else{
              $("#name_warning_msg").html("Course name is free.");
              // return true;
              document.getElementById("add_course_form").submit();
            }
          }
        });

      }

    </script>
</head>
<body>
     <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="courses.php">Course</a></li>
    <li class="active">Add Course</li>
    </ol>

<center>
Add new course
<hr>
<?php
if(isset($_GET['action'])=='addcourse') {
    addcourse();
}else
//show form
?>
<table class = "table table-bordered">
<tr>
  <form action="?action=addcourse" id="add_course_form" name="add_course_form" method="post" onsubmit="return(validate())">
  <input type="hidden" type="text" name="cid" value="<?php echo $courseid ?>">
  <td>Course Name:</td><td><input type="text" name="cname"><div id="name_warning_msg"></div></td>
</tr>
<tr>
  <!-- <td>Course Description</td><td><input type="text" name="cdesc"></td> -->
  <td>Course Description</td><td><textarea name="cdesc" cols="100" rows="10"></textarea></td>
</tr>
</table>
<div align = "center" ><input  class="btn btn-default" type="submit" value="Add">&nbsp&nbsp<input  class="btn btn-default" type="reset"></div>
</form>



<?php

 function addcourse() 
 {
    include'../inc/db_config.php';
    $add_courseid=intval($_POST['cid']);
	$add_coursename=$_POST['cname'];
	$add_coursedesc=$_POST['cdesc'];

  $create_user = "-";
  if(isset($_SESSION['username'])){
    $create_user = $_SESSION['username'];
  }

	$date = date('Y-m-d H:i:s');

  date_default_timezone_set("Asia/Kuching");
  $create_time  = date("Y-m-d h:i:s");
  $modify_user  = "-";
  $modify_time  = "0000-00-00 00:00:00";
  $delete_user  = "-";
  $delete_time  = "0000-00-00 00:00:00";
  $rec_status   = "-";

  $flag=true;
	$check="select * from course";
	$check_result=mysql_query($check,$link);
		while($result_rows=mysql_fetch_object($check_result))
		{
    		if(strcmp($add_coursename,$result_rows->coursename)!=0 && $result_rows->courseid!=$add_courseid)
        	$flag=false;
    		else
        	$flag=true;
		}
    
    if($flag==false)
    {
            $sql="insert into course(courseid,coursename,created,description) values('$add_courseid','$add_coursename','$date','$add_coursedesc')";
            
            // New insert query_03/05/2015
            $query_insert_course = "INSERT INTO course
                                    ( courseid, coursename, created, description,
                                      created_on, created_by,
                                      modified_on, modified_by
                                      )
                                    VALUES
                                    ( '$add_courseid', '$add_coursename', '$date', '$add_coursedesc',
                                      '$create_time', '$create_user',
                                      '$modify_time', '$modify_user'
                                      )";

            if(!mysql_query($query_insert_course,$link)){
             die("Could not add new course.".mysql_error());
            }else
            {
                echo '<script> alert("Add Course Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="courses.php" </script>';
            }
        
       
    }
    else{
        echo "Course Existed ";
    }

}
?>

<?php

mysql_close($link);
?>

<br>
<a href="courses.php">Return</a>
</center> 
</body>
</html>