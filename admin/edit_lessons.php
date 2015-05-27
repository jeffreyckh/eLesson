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

        if($urank == 2)
        {
            include '../inc/normalAdminNav.php';
        }
        else
        {
           include 'adminNav.php'; 
        }
    
    $m_id=intval($_REQUEST['lid']);
    $query="select lessonname,lessoncontent,direction_id from lesson where lessonid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_lessonname=$m_rows->lessonname;
        $m_lessoncontent=$m_rows->lessoncontent;
        $m_directionid=$m_rows->direction_id;
    }

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
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
   <script src="../jscss/tinymce/tinymce.min.js"></script>
   <script src="../jscss/editor.js"></script>
    <script type="text/javascript">
        function validateForm(){
            if(document.edit_lesson_form.lname.value == ""){
                alert("Lesson name is empty. Please enter a lesson name.");
                return false;
            }

            l_name = document.edit_lesson_form.lname.value;
            checkLesson(l_name);
            return false;
        }

        function checkLessonName(l_name){
            $.ajax({
                url: "check_lesson.php",
                type: 'POST',
                data:{

                },
                success: function(msg){
                    alert("Msg Sent");
                }
            });
        }

        function checkLesson(){
            check_url = "check_lesson.php";
            /*l_name = document.getElementsByName("lname").value;*/
            /*l_name = escape(l_name.value);*/
            l_name = document.edit_lesson_form.lname.value;
            /*alert(l_name);*/
            check_url = check_url + "?l_name=" + l_name;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("name_warning_msg").innerHTML = xmlhttp.responseText;
                    xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", check_url, true);
            xmlhttp.send();
        }
    </script>
</head>
<body>
<center>
Modify Lesson Details
</center>
<hr>
<div id="test"></div>
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
    <td>Lesson Name:</td>
    <td>
        <input type="text" name="lname" size="35" value="<?php echo $m_lessonname ?>">
        <!-- <button type="button" onclick="return(checkLesson())">Check Lesson Name</button> -->
        <div id="name_warning_msg" style="display:inline;"></div>
    </td>
</tr>

<tr>
    <td>Lesson Content:</td>
    <td>
        <textarea name="lcont" id="lcont" rows="10" cols="80"><?php echo $m_lessoncontent ?></textarea>
    </td>  
</tr>
<tr>
    <td>
        
        
    </td>
    <td><input class="btn btn-default" type="submit" value="Change">&nbsp;<input class="btn btn-default" type="reset">

</td></tr>

</table>
</form>
<script>
    editor();
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
                echo $flag;

            }

        }

    // Check if submitted fields are different
    $modify_flag = false;
    $query_select_check = "SELECT lessonname, lessoncontent FROM lesson WHERE lessonid = '$m_id'";
    $check_select_result = mysql_query($query_select_check, $link);
    while($result_rows = mysql_fetch_array($check_select_result, MYSQL_ASSOC)){

        if(strcmp($edit_name, $result_rows["lessonname"])==0 && strcmp($edit_content, $result_rows["lessoncontent"])==0){
            $modify_flag = true;
        }

    }
    $editedcontent = addslashes($edit_content);
    if($flag==false)
    {
        $query_update = "";
        $query_update_course = "";
        // Modification changed lesson data, update modification record info

        if($modify_flag == false){

            date_default_timezone_set("Asia/Kuching");
            $modify_time = date('Y-m-d H:i:s');
            $modify_user = $_SESSION['username'];

            $query_update = "UPDATE lesson SET
                            lessonname = '$edit_name', lessoncontent = '$editedcontent',
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
                            lessonname = '$edit_name', lessoncontent = '$editedcontent'
                            WHERE lessonid = '$m_id'";
        }
            
            if(!mysql_query($query_update, $link))
             die("Could not update the data!".mysql_error());
            else
            {
                update_lesson_history($m_id);

                mysql_query($query_update_course, $link);
                $query="SELECT direction_id from lesson where lessonid=$m_id";
                $result=mysql_query($query,$link);
                while($m_rows=mysql_fetch_object($result))
                {
                    $m_directionid = $m_rows->direction_id;
                }

                mysql_query("UPDATE course SET mod_time = mod_time + 1 WHERE courseid = $m_directionid");

                echo '<script> alert("Modify Lesson Successful!") </script>';
                
                echo '<script language="JavaScript"> window.location.href ="courses_info.php?cid= '. $m_directionid . '" </script>';
                header("Location: courses_info.php?cid=$m_directionid");
                
            }
    }
    else{
        echo " Existed";
    }

}

function update_lesson_history($lesson_id){
    global $link;
    // Insert modified lesson into lesson history 
    $query_select = "SELECT * FROM lesson WHERE lessonid='$lesson_id'";
    $result = mysql_query($query_select, $link);
    $arr_result = mysql_fetch_assoc($result);
    $revision_time = "";
    $last_user = "";

    $query_insert_hist = "INSERT INTO lesson_history(
                                    lessonid, lessonname, created, lessoncontent, direction_id,
                                    created_on, created_by, modified_on, modified_by,
                                    deleted_on, deleted_by, rec_status, version_id, latest_revision_time, latest_user
                                )
                                VALUES(";
    foreach($arr_result as $key => $value){
    $query_insert_hist .=  "'" . $value . "',";

    if($key == "modified_on"){
      $revision_time = "'" . $value . "'";
    }

    if($key == "modified_by"){
      $last_user = "'" . $value . "'";
    }
  }

  $query_insert_hist .= $revision_time;
  $query_insert_hist .= ",";
  $query_insert_hist .= $last_user;
  $query_insert_hist .= ")";

    if(!mysql_query($query_insert_hist, $link)){
        // echo "Checkpoint";
        die("Could not add lesson history.".mysql_error());
    }else{
    // echo '<script> alert("Lesson ") </script>';
    }
}

?>
</table>
<br>
<center>
<a href="courses_info.php?cid=<?php echo $m_directionid ?>">Return</a>
</center>
&nbsp;
<?php
mysql_close($link);
?>
