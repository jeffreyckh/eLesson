<?php
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
$query_count="select count(*) from course";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;
?>
<center>
Add new course
<hr>

<?php
if(isset($_GET['action'])=='addcourse') {
    addcourse();
}else
//show form
?>
<table>
<tr>
 <form action="?action=addcourse" method="post">
<td>Course ID:</td><td><input type="text" name="cid" value="<?php echo $count ?>"></td></tr>
<td>Course Name:</td><td><input type="text" name="cname"></td></tr>
<td>Course Description</td><td><input type="text" name="cdesc"></td></tr>
<tr><td><input type="submit" value="Add"></td><td><input type="reset"></td></tr>
</form>
</table>


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

<br>
<a href="courses.php">Return</a>
</center> 