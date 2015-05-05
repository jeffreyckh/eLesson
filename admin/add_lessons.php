<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$temp_id;
//$query_count="select count(*) from lesson";
//$result_count=mysql_query($query_count,$link);
//$count=mysql_result($result_count,0) + 1;
if(isset($_REQUEST['cid'])){
  $courseid = intval($_REQUEST['cid']);  
}

$query = " select * from lesson order by lessonid DESC limit 1";
$result = mysql_query($query,$link);
 while($m_rows=mysql_fetch_object($result))
    {
        $lessonid = $m_rows->lessonid + 1;
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Add Lessons</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
      function validateForm(){
        var warning_string = "";
        
        if(document.add_lesson_form.lname.value == ""){
          alert("Please enter a lesson name.");
          warning_string += "Please enter a lesson name.\n";
          return false;
        }else{
          var l_name = document.add_lesson_form.lname.value;
          // alert("Checking..."+l_name);
          var state = checkLessonName(l_name);
          /*alert("State: "+state);*/
          return false;
        }

        return false;
      }

      function checkLessonName(l_name){
        $.ajax({
          url: "check_lesson.php",
          type: "POST",
          data: "l_name=" + l_name,
          success: function(data){
            // alert(data);
            if(data == 1){
              $("#name_warning_msg").html("Lesson name is taken, choose another.");
              // return false;
            }else{
              $("#name_warning_msg").html("Lesson name is free.");
              // return true;
              document.getElementById("add_lesson_form").submit();
            }
          }
        });

      }
    </script>
</head>
<body>
<center>
Add new lesson
<hr>

<?php
if(isset($_GET['action'])=='addlesson') {
    addlesson();
}else
//show form
?>
<table class="table table-bordered">
<tr>
 <form id="add_lesson_form" name="add_lesson_form" action="?action=addlesson" method="post" onsubmit="return(validateForm())">
  <input type="hidden" name="lid" value="<?php echo $lessonid ?>">
  <input type="hidden" name="cid" value="<?php echo $courseid ?>">
<td>Lesson Name:</td>
  <td>
    <input type="text" name="lname">
    <div id="name_warning_msg"></div>
  </td></tr>
<tr><td>Lesson Content:</td><td>
<textarea name="lcont" id="lcont" rows="10" cols="80"></textarea>
</td></tr>
<input type="hidden" name="cid" value="<?php echo $courseid ?>">
<tr><td><input class="btn btn-default" type="submit" value="Add"><?php echo "&nbsp &nbsp";?>
    <input class="btn btn-default" type="reset"></td></tr>
</form>
</table>
   <script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace('lcont', {
        "filebrowserImageUploadUrl": "/path_to/ckeditor/plugins/imgupload.php"
      });
      //CKEDITOR.replace( 'lcont' );
  </script>
</body>
</html>


<?php

 function addlesson() 
 {
    include '../inc/db_config.php';
    $add_directionid      = intval($_POST['cid']);
    $add_lessonid         = intval($_POST['lid']);
  	$add_lessonname       = $_POST['lname'];
  	$add_lessoncontent    = $_POST['lcont'];
  	$date                 = date('Y-m-d H:i:s');

    $create_user = "-";
    if(isset($_SESSION['username'])){
      $create_user = $_SESSION['username'];
    }
    date_default_timezone_set("Asia/Kuching");
    $create_time  = date("Y-m-d h:i:s");
    $modify_user  = "-";
    $modify_time  = "0000-00-00 00:00:00";
    $delete_user  = "-";
    $delete_time  = "0000-00-00 00:00:00";
    $rec_status   = "-";

	$flag          = true;
	$check         = "select * from lesson";
	$check_result  = mysql_query($check,$link);
		while($result_rows = mysql_fetch_object($check_result))
		{
    		if(strcmp($add_lessonid,$result_rows->lessonname)!=0 && $result_rows->lessonid!=$add_lessonid && $result_rows->lessonname != $add_lessonname)
        	$flag=false;
    		else
        	$flag=true;
		}
    
    if($flag==false)
    {
            $sql="insert into lesson(lessonid,lessonname,created,lessoncontent,direction_id) values('$add_lessonid','$add_lessonname','$date','$add_lessoncontent','$add_directionid')";
            
            $query_insert_lesson = "INSERT INTO lesson
                                    ( lessonid, lessonname, created, lessoncontent, direction_id,
                                      created_on, created_by,
                                      modified_on, modified_by,
                                      deleted_on, deleted_by,
                                      rec_status )
                                    VALUES
                                    ( '$add_lessonid','$add_lessonname','$date','$add_lessoncontent','$add_directionid',
                                      '$create_time', '$create_user',
                                      '$modify_time', '$modify_user',
                                      '$delete_time', '$delete_user',
                                      '$rec_status')";

            if(!mysql_query($query_insert_lesson,$link)){
             die("Could not add new lesson.".mysql_error());
            }else
            {
              update_lesson_history($add_lessonid);

              date_default_timezone_set("Asia/Kuching");
              $modify_time = date('Y-m-d H:i:s');
              $modify_user = $_SESSION['username'];
              $last_inserted_id = mysql_insert_id();

              // Get direction_id to update modification information of the course
              $query_select_course = "SELECT direction_id FROM lesson WHERE lessonid = '$add_lessonid'";
              $select_course_result = mysql_query($query_select_course, $link);

              while($row = mysql_fetch_object($select_course_result)){
                $course_id = $row->direction_id;
              }

              $query_update_course = "UPDATE course SET
                                      modified_on = '$modify_time', modified_by = '$modify_user'
                                      WHERE courseid = '$course_id'";

              mysql_query($query_update_course, $link);
                // echo $query_update_course;
                echo '<script> alert("Add Lesson Successful!") </script>';
                /*echo '<script language="JavaScript"> window.location.href ="courses_info.php?cid=<?php echo $add_directionid?>"</script>';*/
                header("Location: courses_info.php?cid=$add_directionid");
            }
        
       
    }
    else{
        echo "Lesson Existed ";
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



<br>
<a href="courses_info.php?cid=<?php echo $courseid ?>">Return</a>
</center> 

<?php

mysql_close($link);
?>