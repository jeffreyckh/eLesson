<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    //include 'adminNav.php';
    $m_id=intval($_REQUEST['cid']);
    $query="select coursename,description from course where courseid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_coursename=$m_rows->coursename;
        $m_coursedesc=$m_rows->description;
    }
      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Edit Course</title>
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
    <li><a href="courses.php">Courses</a></li>
    <li class="active">Edit Course</li>
    </ol>
Modify Course Detail
<hr>

<?php
if(isset($_GET['action'])=='editcourse') {
    editcourse();
}else
//show form
?>
<form action="?action=editcourse?cid=<?php echo $m_id ?>" method="post">
<input type="hidden" name="cid" value="<?php echo $m_id ?>">
<table class="table table-bordered">
<tr>
    <td>Course Name:</td><td><input type="text" name="cname" value="<?php echo $m_coursename ?>"></td></tr>
    <tr><td>Course Description:</td>
    <td><textarea name="cdesc" id="cdesc" rows="10" cols="80"><?php echo $m_coursedesc; ?></textarea> 
    </td>  
    </tr>
</table>
<div class="row">
<div align = "center">
    <button type="submit" class="btn btn-default">Submit</button>&nbsp&nbsp<button type="reset" class="btn btn-default">Reset</button>
</div>
</form>
<br><br>
</body>
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

</html>