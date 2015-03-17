<?php
    session_start();
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Modify Course Detail</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>

Modify Course Detail
<hr>

<?php
if(isset($_GET['action'])=='editlesson') {
    editlesson();
}else
//show form
?>
<form action="?action=editlesson" method="post">
<input type="hidden" name="lid" value="<?php echo $m_id ?>">
<table class="table table-bordered">
<tr>
    <td>Lesson Name:</td><td><input type="text" name="lname" value="<?php echo $m_lessonname ?>"></td></tr>
    <tr><td>Lesson Content:</td><td>
    <textarea name="lcont" id="lcont" rows="10" cols="80"><?php echo $m_lessoncontent ?></textarea>
</td>  
</tr>
<tr><td><input type="submit" value="Change"></td><td><input type="reset"></td></tr>
</table>
</form>
<script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace( 'lcont' );
  </script>
  </body>
  </html>
<?php
function editlesson() 
 {
 include("../inc/db_config.php");
    $m_id=intval($_POST['lid']);
    //$m_did = intval($POST['cid']);
    $edit_name=$_POST['lname'];
    $edit_content=$_POST['lcont'];

    $modify_time = "";
    $modify_user = "";

    $flag = false;
    // $check="select * from lesson";
    $query_check = "SELECT * FROM lesson WHERE lessonid != '$m_id'";
    $check_result=mysql_query($query_check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(strcmp($edit_name, $result_rows->lessonname) == 0){
                $flag = true;
            }
            // if(strcmp($edit_name,$result_rows->lessonname)!=0 && $edit_name != $result_rows->lessonname)
            // $flag=false;
            // else
            // $flag=true;
        }

    // Check if submitted fields are different
    $modify_flag = false;
    $query_select_check = "SELECT lessonname, lessoncontent FROM lesson WHERE lessonid = '$m_id'";
    $check_select_result = mysql_query($query_select_check, $link);
    while($result_rows = mysql_fetch_array($check_select_result, MYSQL_ASSOC)){
        if(strcmp($edit_name, $result_rows["lessonname"])!=0){
            $modify_flag = true;
        }
        if(strcmp($edit_content, $result_rows["lessoncontent"])!=0){
            $modify_flag = true;
        }
    }
    
    if($flag==false)
    {
        $query_update = "";
        $query_update_course = "";
        // Modification changed lesson data, update modification record info
        if($modify_flag == true){
            date_default_timezone_set("Asia/Kuching");
            $modify_time = date('Y-m-d H:i:s');
            $modify_user = $_SESSION['username'];

            $query_update = "UPDATE lesson SET
                            lessonname = '$edit_name', lessoncontent = '$edit_content',
                            modified_on = '$modify_time', modified_by = '$modify_user'
                            WHERE lessonid = '$m_id'";

            // Get direction_id to update modification information of the course
            $query_select_course = "SELECT direction_id FROM lesson WHERE lessonid = '$m_id'";
            $select_course_result = mysql_query($query_select_course, $link);
            while($row = mysql_fetch_object($select_course_result)){
                $course_id = $row->direction_id;
            }

            $query_update_course = "UPDATE course SET
                                    modified_on = '$modify_time', modified_by = '$modify_user'
                                    WHERE courseid = '$course_id'";
        }else{
            $query_update = "UPDATE lesson SET
                            lessonname = '$edit_name', lessoncontent = '$edit_content'
                            WHERE lessonid = '$m_id'";
        }
            // $sql="update lesson set lessonname='$edit_name',lessoncontent='$edit_content' where lessonid=$m_id";
            
            if(!mysql_query($query_update, $link))
             die("Could not update the data!".mysql_error());
            else
            {
                mysql_query($query_update_course, $link);
                $query="select direction_id from lesson where lessonid=$m_id";
                $result=mysql_query($query,$link);
                while($m_rows=mysql_fetch_object($result))
                {
                    $m_directionid = $m_rows->direction_id;
                }
                echo '<script> alert("Modify Lesson Successful!") </script>';
                
                echo '<script language="JavaScript"> window.location.href ="courses_info.php?cid= '. $m_directionid . '" </script>';
                //header("Location: courses_info.php?cid=$m_directionid");
                
            }
    }
    else{
        echo " Existed";
    }

}


?>
</table>
<br>
<a href="courses_info.php?cid=<?php echo $m_directionid ?>">Return</a>

<?php
mysql_close($link);
?>
