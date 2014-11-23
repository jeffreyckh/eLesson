<?php
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    $m_id=intval($_REQUEST['cid']);
    $query="select coursename,description from course where courseid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_coursename=$m_rows->coursename;
        $m_coursedesc=$m_rows->description;
    }
      
?>
Change Course Detail
<hr>

<?php
if(isset($_GET['action'])=='editcourse') {
    editcourse();
}else
//show form
?>
<form action="?action=editcourse?cid=<?php echo $m_id ?>" method="post">
<input type="hidden" name="cid" value="<?php echo $m_id ?>">
<table>
<tr>
    <td>Course Name:</td><td><input type="text" name="cname" value="<?php echo $m_coursename ?>"></td>
    <td>Course Description:</td><td><input type="textarea" name="cdesc" value="<?php echo $m_coursedesc ?>"></td>
</tr>


<tr><td><input type="submit" value="Change"></td><td><input type="reset"></td></tr>
</form>
<?php
function editcourse() 
 {
 include("../inc/db_config.php");
    $m_id=intval($_POST['cid']);
    $edit_name=$_POST['cname'];
    $edit_desc=$_POST['cdesc'];
    $flag=true;
    $check="select * from course";
    $check_result=mysql_query($check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(strcmp($edit_name,$result_rows->coursename)!=0)
            $flag=false;
            else
            $flag=true;
        }
    
    if($flag==false)
    {
       
            $sql="update course set coursename='$edit_name',description='$edit_desc' where courseid=$m_id";
            if(!mysql_query($sql,$link))
             die("Could not update the data!".mysql_error());
            else
            {
                echo '<script> alert("Modify Course Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="courses.php" </script>';
                
            }
    }
    else{
        echo "Course Existed";
    }

}

mysql_close($link);
?>
</table>
<br>
<a href="courses.php">Return</a>

