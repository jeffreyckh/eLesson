<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
//include 'adminNav.php';
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
 <form action="?action=addcourse" method="post">
<input type="hidden" type="text" name="cid" value="<?php echo $count ?>">
<td>Course Name:</td><td><input type="text" name="cname"></td></tr>
<td>Course Description</td><td><input type="text" name="cdesc"></td></tr>
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
	$date = date('Y-m-d H:i:s');
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
            
            if(!mysql_query($sql,$link)){
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

</center> 
</body>
</html>