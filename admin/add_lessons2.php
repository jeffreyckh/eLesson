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
    <script src="../jscss/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
      function validateForm(){
        var warning_string = "";
        if(document.add_lesson_form.select.value == ""){
          alert("Please select a course.");
          return false;
        }

        if(document.add_lesson_form.lname.value == ""){
          alert("Please enter a lesson name.");
          warning_string += "Please enter a lesson name.\n";
          return false;
        }else{
          var l_name = document.add_lesson_form.lname.value;
          var state = checkLessonName(l_name);
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
            if(data == 1){
              $("#name_warning_msg").html("Lesson name is taken, choose another.");
            }else{
              $("#name_warning_msg").html("Lesson name is free.");
              document.getElementById("add_lesson_form").submit();
            }
          }
        });

      }

    </script>
</head>
<body>
<center>
Add New Lesson
<hr>

<?php
if(isset($_GET['action'])=='addlesson') {
    addlesson();
}
else
//show form
?>
<table class="table table-bordered">
<tr>
<form id="add_lesson_form" name="add_lesson_form" action="?action=addlesson" method="post" onsubmit="return(validateForm())">
<td>Course:</td>
<td>
    <select name="select">
    <?php 
    $query2 = "SELECT * from course";
    $result2 = mysql_query($query2,$link);
    ?>
      <option value='' disabled selected> --- Select a Course --- </option>
    <?php
    while($b_rows=mysql_fetch_object($result2)){
      if($courseid == $b_rows->courseid){
        ?>
        <option value="<?php echo $b_rows->courseid ?>" selected><?php echo $b_rows->coursename ?></option>
        <?php
      }else{
    ?>
      <option value="<?php echo $b_rows->courseid ?>"><?php echo $b_rows->coursename ?></option>
    <?php
      }
    }
    ?>
    </select>
  </td></tr>
  <input type="hidden" name="lid" value="<?php echo $lessonid ?>">
<td>Lesson Name:</td><td><input type="text" name="lname"><div id="name_warning_msg"></div></td></tr>
<td>Lesson Content:</td><td>
<textarea name="lcont" id="lcont" rows="10" cols="80">
</textarea>
</td></tr>
<tr><td>
      
    </td>
    <td>
      <input class="btn btn-default" type="submit" value="Add">
      <input class="btn btn-default" type="reset">
    </td>
  </tr>
</form>
</table>
<script>
      tinymce.init({
    selector: "textarea",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager media youtube"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code | youtube",
   image_advtab: true ,
   external_filemanager_path:"/eLesson/jscss/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "/eLesson/jscss/filemanager/plugin.min.js"}
    
    });
  </script>
</body>
</html>

 <?php
 function addlesson() 
 {
    include'../inc/db_config.php';
    $add_directionid    = intval($_POST['select']);
    $add_lessonid       = intval($_POST['lid']);
    $add_lessonname     = $_POST['lname'];
    $add_lessoncontent  = $_POST['lcont'];
    $date               = date('Y-m-d H:i:s');

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

    $flag         = true;
    $check        = "SELECT * from lesson";
    $check_result = mysql_query($check,$link);
		while($result_rows=mysql_fetch_object($check_result))
		{
    		if(strcmp($add_lessonid,$result_rows->lessonname)!=0 && $result_rows->lessonid!=$add_lessonid && $result_rows->lessonname != $add_lessonname)
        	$flag=false;
    		else
        	$flag=true;
		}
    $addedlessoncontent = addslashes($add_lessoncontent);
    if($flag==false)
    {
            $sql="insert into lesson(lessonid,lessonname,created,lessoncontent,direction_id) values('$add_lessonid','$add_lessonname','$date','$addedlessoncontent','$add_directionid')";
            
            $query_insert_lesson = "INSERT INTO lesson
                                    ( lessonid, lessonname, created, lessoncontent, direction_id,
                                      created_on, created_by,
                                      modified_on, modified_by,
                                      deleted_on, deleted_by,
                                      rec_status )
                                    VALUES
                                    ( '$add_lessonid','$add_lessonname','$date','$addedlessoncontent','$add_directionid',
                                      '$create_time', '$create_user',
                                      '$modify_time', '$modify_user',
                                      '$delete_time', '$delete_user',
                                      '$rec_status')";

            if(!mysql_query($query_insert_lesson,$link)){
             die("Could not add new lesson.".mysql_error());
            }else
            {
                update_lesson_history($add_lessonid);
                echo '<script> alert("Add Lesson Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="viewlesson.php"</script>';
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

    if($key == "created_on"){
      $revision_time = "'" . $value . "'";
    }

    if($key == "created_by"){
      $last_user = "'" . $value . "'";
    }
  }

  $query_insert_hist .= $revision_time;
  $query_insert_hist .= ",";
  $query_insert_hist .= $last_user;
  $query_insert_hist .= ")";

    if(!mysql_query($query_insert_hist, $link)){
        die("Could not add lesson history.".mysql_error());
    }else{
    }
}
?>


<br>
<a href="viewlesson.php">Return</a>
</center> 
&nbsp;
<?php

mysql_close($link);
?>
