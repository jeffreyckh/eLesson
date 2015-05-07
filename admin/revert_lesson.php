<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    include '../finediff/finediff.php';
    $m_id   = intval($_REQUEST['l_hid']);
    $query  = "SELECT * from lesson_history where lesson_hist_id=$m_id";
    $result = mysql_query($query, $link);

    while($m_rows=mysql_fetch_object($result))
    {
        $m_lessonid         = $m_rows->lessonid;
        $m_lessonname       = $m_rows->lessonname;
        $m_lessoncontent    = $m_rows->lessoncontent;
            $m_lessoncontent = str_replace("&nbsp;", ' ', $m_lessoncontent);
            // echo $m_lessoncontent;
            $m_lessoncontent = htmlspecialchars_decode($m_lessoncontent);
            // echo htmlspecialchars($m_lessoncontent);
        $m_directionid      = $m_rows->direction_id;
    }

    // Get current lesson detail
    $query_current  = "SELECT * from lesson where lessonid=$m_lessonid";
    $result_current = mysql_query($query_current, $link);

    while($m_rows=mysql_fetch_object($result_current))
    {
        $c_lessonid         = $m_rows->lessonid;
        $c_lessonname       = $m_rows->lessonname;
        $c_lessoncontent    = $m_rows->lessoncontent;
            $c_lessoncontent = str_replace("&nbsp;", ' ', $c_lessoncontent);
            // echo $c_lessoncontent;
            $c_lessoncontent = htmlspecialchars_decode($c_lessoncontent);
            // echo htmlspecialchars($c_lessoncontent);
        $c_directionid      = $m_rows->direction_id;
    }

    // Use finediff to compare difference between strings
    $opcodes = FineDiff::getDiffOpcodes(
            $m_lessoncontent, $c_lessoncontent, 
            FineDiff::$characterGranularity
        );

    $diff_text = FineDiff::renderDiffToHTMLFromOpCodes(
            $m_lessoncontent, $opcodes
        );

    // Check if there are existing backups
    // $show_undo = false;
    // $query_check_backup = "SELECT lesson_backup_id FROM lesson_backup WHERE lessonid=$m_id";
    // $result_check_backup = mysql_query($query_check_backup, $link);
    // if(mysql_num_rows($result_check_backup) == 0){
    //     $show_undo = false;
    // }else{
    //     $show_undo = true;
    // }
    
      //echo $m_directionid;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Revert Lesson Detail</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/tinymce/tinymce.min.js"></script>
    
    <style type="text/css">
        del{
            background-color: pink;
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        div#prev-rev del p{
            background-color: pink;
        }

        ins{
            background-color: lightgreen;
            color: green;
            text-decoration: none;
            font-weight: bold;
        }

        div#curr-rev ins p{
            background-color: lightgreen;
        }

        div#prev-rev ins{
            visibility: hidden;
            display: none;
        }
        div#curr-rev del{
            visibility: hidden;
            display: none;
        }
        div#prev-rev{
            font-size: 12px;
        }
        div#curr-rev{
            font-size: 12px;
        }
        .table>tbody>tr>td.lcontent{
            vertical-align: top;
        }
    </style>
</head>
<body>

<center><h3>Revert Lesson Detail</h3></center>
<hr>

<?php
if(isset($_GET['action'])=='editlesson') {
    editlesson();
}else if(isset($_POST['edit'])){
    editlesson();
}else if(isset($_POST['change'])){
    
}else
//show form
?>
<!-- Table to show difference between latest lesson revision and previous lesson revision -->
<center>
<table id="diff-table" class="table table-striped table-bordered" width="1000" border="1">
    <thead>
        <th width="50%" align="center"><b>Revision</b></th>
        <th width="50%" align="center"><b>Latest Revision</b></th>
    </thead>
    <tr>
        <td><strong>Lesson Content:</strong></td>
        <td><strong>Lesson Content:</strong></td>
    </tr>
    <tr>
        <td class="lcontent">
            <div id="prev-rev">
            <?php echo htmlspecialchars_decode($diff_text) ?>
            <!-- <?php echo $diff_text ?> -->
            </div>
        </td>
        <td class="lcontent">
            <div id="curr-rev">
            <?php echo htmlspecialchars_decode($diff_text) ?>
            <!-- <?php echo $diff_text ?> -->
            </div>
        </td>
    </tr>
</table>
</center>
<!-- <table class="table table-bordered">
    <tr>
        <th colspan="2">Current Revision</th>
    </tr>
    <tr>
        <td>Lesson Name:</td>
        <td><?php echo $c_lessonname ?></td>
    </tr>
    <tr>
        <td>Lesson Content:</td>
        <td>
        <?php echo $c_lessoncontent ?>
        </td>  
    </tr>
</table> -->

<form method="post">
<input type="hidden" name="lid" value="<?php echo $m_lessonid ?>">
<table class="table table-bordered">
<tr>
    <th colspan="2">Revert Version</th>
</tr>
<tr>
    <td>Lesson Name:</td>
    <td><input type="text" name="lname" value="<?php echo $m_lessonname ?>"></td>
</tr>
<tr>
    <td>Lesson Content:</td>
    <td>
    <textarea name="lcont" id="lcont" rows="10" cols="80"><?php echo $m_lessoncontent ?></textarea>
    </td>  
</tr>
<tr>
    <td>
        <input name="edit" id="edit" type="submit" value="Change">
        
    </td>
    <td><input type="reset">

</td></tr>
</table>
</form>
<script>
      tinymce.init({
    selector: "textarea",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
   image_advtab: true ,
   external_filemanager_path:"/eLesson/jscss/filemanager/",
   filemanager_title:"Responsive Filemanager" ,
   external_plugins: { "filemanager" : "/eLesson/jscss/filemanager/plugin.min.js"}
    
 });
  </script>
  <a href="lesson_history.php?lid=<?php echo $c_lessonid ?>" class = " btn btn-default">Return</a>
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
    echo $query_check;
    $check_result=mysql_query($query_check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
            // echo $result_rows->lessonname."<br>";
            if(strcmp($edit_name, $result_rows->lessonname) == 0){
                
                $flag = true;
                echo $flag;
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
        if(strcmp($edit_name, $result_rows["lessonname"])==0 && strcmp($edit_content, $result_rows["lessoncontent"])==0){
            $modify_flag = true;
        }
        // if(strcmp($edit_content, $result_rows["lessoncontent"])==0){
        //     $modify_flag = true;
        // }
    }
    
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
            
            // backup($m_id);

            if(!mysql_query($query_update, $link))
             die("Could not update the data!".mysql_error());
            else
            {
                update_lesson_history($m_id);
                mysql_query($query_update_course, $link);
                $query="select direction_id from lesson where lessonid=$m_id";
                $result=mysql_query($query,$link);
                while($m_rows=mysql_fetch_object($result))
                {
                    $m_directionid = $m_rows->direction_id;
                }
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
        die("Could not add lesson history.".mysql_error());
    }else{
    // echo '<script> alert("Lesson ") </script>';
    }
}

function backup($lesson_id){
    global $link;
    // Create backup for modified lesson
    // load original record into an array
    $query_select = "SELECT * FROM lesson WHERE lessonid='$lesson_id'";
    $result = mysql_query($query_select, $link);
    $arr_result = mysql_fetch_assoc($result);

    // insert new record and get auto_increment id

    // generate the query to update the new record with the previous values

    // Check if there is an available backup
    // Check lesson_backup table
    $query_check_backup = "SELECT * FROM lesson_backup WHERE lessonid='$lesson_id'";
    $result_check_backup = mysql_query($query_check_backup, $link);

    if(mysql_num_rows($result_check_backup) == 0){
        // Backup does not exist, insert a new backup
        $query_insert_backup = "INSERT INTO lesson_backup(
                                    lessonid, lessonname, created, lessoncontent, direction_id,
                                    created_on, created_by, modified_on, modified_by,
                                    deleted_on, deleted_by, rec_status
                                )
                                VALUES(";
        $query_value_string = "";
        $backup_id = "";
        foreach ($arr_result as $field => $value) {
            
            $query_value_string .=  "'" . $value . "',";
            
        }
        $query_value_string = substr($query_value_string, 0, strlen($query_value_string)-1);
        $query_insert_backup = $query_insert_backup.$query_value_string.")";
        echo $query_insert_backup;
        
        if(!mysql_query($query_insert_backup, $link)){
            die("Could not add new lesson.".mysql_error());
        }else{
            
        }
    }else{
        // Backup exists, update backup
        $query_update_backup = "UPDATE lesson_backup SET ";
        $query_value_string = "";

        foreach ($arr_result as $key => $value) {
            if($key=="lessonid"){

            }else{
                $query_value_string .= $key."='".$value."',";
            }
        }
        echo $lesson_id;
        $query_value_string = substr($query_value_string, 0, strlen($query_value_string)-1);
        $query_update_backup .= $query_value_string." WHERE lessonid='$lesson_id'";
        echo $query_update_backup;

        if(!mysql_query($query_update_backup, $link)){
            die("Could not add new lesson.".mysql_error());
        }else{
            
        }
    }

}