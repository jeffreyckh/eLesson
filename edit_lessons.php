<?php
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    $m_id=intval($_REQUEST['lid']);
    $query="select lessonname,lessoncontent,direction_id from lesson where lessonid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_lessonname=$m_rows->lessonname;
        $m_lessoncontent=$m_rows->lessoncontent;
        $m_directionid=$m_rows->direction_id;
    }

    
      //echo $m_directionid;
?>
Change Course Detail
<hr>

<?php
if(isset($_GET['action'])=='editlesson') {
    editlesson();
}else
//show form
?>
<form action="?action=editlesson" method="post">
<input type="hidden" name="lid" value="<?php echo $m_id ?>">
<table>
<tr>
    <td>Lesson Name:</td><td><input type="text" name="lname" value="<?php echo $m_lessonname ?>"></td>
    <td>Lesson Content:</td><td><textarea name="lcont" rows="5" cols="40"><?php echo $m_lessoncontent ?></textarea></td>
    
</tr>

<tr><td><input type="submit" value="Change"></td><td><input type="reset"></td></tr>
</form>
<?php
function editlesson() 
 {
 include("../inc/db_config.php");
    $m_id=intval($_POST['lid']);
    //$m_did = intval($POST['cid']);
    $edit_name=$_POST['lname'];
    $edit_content=$_POST['lcont'];
    $flag=true;
    $check="select * from lesson";
    $check_result=mysql_query($check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(strcmp($edit_name,$result_rows->lessonname)!=0 && $edit_name != $result_rows->lessonname)
            $flag=false;
            else
            $flag=true;
        }
    
    if($flag==false)
    {
       
            $sql="update lesson set lessonname='$edit_name',lessoncontent='$edit_content' where lessonid=$m_id";
            if(!mysql_query($sql,$link))
             die("Could not update the data!".mysql_error());
            else
            {
                $query="select direction_id from lesson where lessonid=$m_id";
                $result=mysql_query($query,$link);
                while($m_rows=mysql_fetch_object($result))
                {
                $m_directionid=$m_rows->direction_id;
                }
                echo '<script> alert("Modify Lesson Successful!") </script>';
                
                //echo '<script language="JavaScript"> window.location.href ="courses.php" </script>';
                header("Location: courses_info.php?cid=$m_directionid");
                
            }
    }
    else{
        echo "Course Existed";
    }

}


?>
</table>
<br>
<a href="courses_info.php?cid=<?php echo $m_directionid ?>">Return</a>

<?php
mysql_close($link);
?>
