<?php
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
$query_count="select count(*) from lesson";
$result_count=mysql_query($query_count,$link);
$count=mysql_result($result_count,0) + 1;
$courseid = intval($_REQUEST['cid']);

?>
<center>
Add new lesson
<hr>

<?php
if(isset($_GET['action'])=='addlesson') {
    addlesson();
}else
//show form
?>
<table>
<tr>
 <form action="?action=addlesson" method="post">
<td>Lesson ID:</td><td><input type="text" name="lid" value="<?php echo $count ?>"></td></tr>
<td>Lesson Name:</td><td><input type="text" name="lname"></td></tr>
<td>Lesson Content:</td><td><input type="text" name="lcont"></td></tr>
<input type="hidden" name="cid" value="<?php echo $courseid ?>">
<tr><td><input type="submit" value="Add"></td><td><input type="reset"></td></tr>
</form>
</table>


<?php

 function addlesson() 
 {
    include'../inc/db_config.php';
    $add_directionid=intval($_POST['cid']);
    $add_lessonid=intval($_POST['lid']);
	$add_lessonname=$_POST['lname'];
	$add_lessoncontent=$_POST['lcont'];
	$date = date('Y-m-d H:i:s');
	$flag=true;
	$check="select * from lesson";
	$check_result=mysql_query($check,$link);
		while($result_rows=mysql_fetch_object($check_result))
		{
    		if(strcmp($add_lessonid,$result_rows->lessonname)!=0 && $result_rows->lessonid!=$add_lessonid && $result_rows->lessonname != $add_lessonname)
        	$flag=false;
    		else
        	$flag=true;
		}
    
    if($flag==false)
    {
            $sql="insert into lesson(lessonid,lessonname,created,lessoncontent,direction_id) values('$add_lessonid','$add_lessonname','$date','$add_lessoncontent','$add_directionid')";
            
            if(!mysql_query($sql,$link)){
             die("Could not add new lesson.".mysql_error());
            }else
            {
                echo '<script> alert("Add Lesson Successful!") </script>';
                /*echo '<script language="JavaScript"> window.location.href ="courses_info.php?cid=<?php echo $add_directionid?>"</script>';*/
                header("Location: courses_info.php?cid=$add_directionid");
            }
        
       
    }
    else{
        echo "Lesson Existed ";
    }

}
?>



<br>
<a href="courses_info.php?cid=<?php echo $courseid ?>">Return</a>
</center> 

<?php

mysql_close($link);
?>