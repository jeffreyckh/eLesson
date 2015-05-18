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
    include '../inc/db_config.php';
    include '../inc/header.php';
    if($urank == 2)
        {
            include '../inc/normalAdminNav.php';
        }
        else
        {
           include 'adminNav.php'; 
        }
    
    $m_id=intval($_REQUEST['qid']);
    $query="select quizname,lessonid,quiz_number from quiz where quizid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {

        $m_quizname=$m_rows->quizname;
        $m_NoQ = $m_rows->quiz_number;
        $m_lessonid=$m_rows->lessonid;
    }

      //echo $m_directionid;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Modify Quiz</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>

Modify Quiz
<hr>

<?php
if(isset($_GET['action'])=='editquiz') {
    editquiz();
}else
//show form
?>
<form action="?action=editquiz" method="post">
<input type="hidden" name="qid" value="<?php echo $m_id ?>">
<table class="table table-bordered">
<tr>
    <td>Quiz Name:</td><td><input type="text" name="qname" value="<?php echo $m_quizname ?>"></td></tr>

   <td>Lesson:</td>
    <td><select name="select">
     <?php $query2="select * from lesson order by direction_id";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {
                    if($b_rows->lessonid == $m_lessonid)

                    {
    ?>
     
<option value="<?php echo $b_rows->lessonid ?>" selected><?php echo $b_rows->lessonname ?></option>

                    <?php
                    }
                    else 
                    {
    ?>

<option value="<?php echo $b_rows->lessonid ?>"><?php echo $b_rows->lessonname ?></option>
    <?php
}

}
?>
<tr>

    <td>Numbers of Question:</td>
    <td><input type="text" name="NoQ" value = "<?php echo $m_NoQ ?>" ></td>
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
function editquiz() 
 {
 include("../inc/db_config.php");
    $qid = intval($_POST['qid']);
    $m_id = intval($_POST['select']);
    $m_number = intval($_POST['NoQ']);
    
    //$m_did = intval($POST['cid']);
    $edit_name = $_POST['qname'];
    $flag = false;
    $check= "SELECT * FROM quiz";

    $check_result=mysql_query($check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
           // if(strcmp($edit_name,$result_rows->quizname)!=0)
           // $flag=false;
           // else
            //$flag=true;
        }
    
    // Check if submitted fields are different
    $modify_flag = false;
    $query_select_check = "SELECT quizname, lessonid ,quiz_number FROM quiz WHERE quizid = '$qid'";
    $check_select_result = mysql_query($query_select_check, $link);
        while($result_rows = mysql_fetch_array($check_select_result, MYSQL_ASSOC)){
            
            if(strcmp($edit_name, $result_rows["quizname"])!=0){
                $modify_flag = true;
            }
            if($m_id != $result_rows["lessonid"]){
                $modify_flag = true;
            }

             if($m_number != $result_rows["quiz_number"]){
                $modify_flag = true;
            }
        }
        //echo $flag;
    if($flag==false)
    {
            $query_update = "";

            if($modify_flag == true){

              date_default_timezone_set("Asia/Kuching");
              $modify_time = date('Y-m-d H:i:s');
              $modify_user = $_SESSION['username'];

              $sql="update quiz set quizname='$edit_name',lessonid='$m_id' where quizid=$qid";
              $query_update = "UPDATE quiz SET 
                              quizname = '$edit_name', lessonid = '$m_id',
                              modified_on = '$modify_time', modified_by = '$modify_user',quiz_number = '$m_number'
                              WHERE quizid = '$qid'";
            }else{
              $query_update = "update quiz set quizname='$edit_name',lessonid='$m_id',quiz_number = '$m_number' where quizid=$qid";
            }
            if(!mysql_query($query_update, $link))
             die("Could not update the data!".mysql_error());
            else
            {
            
                echo '<script> alert("Modify Quiz Successful!") </script>';
                
                echo '<script language="JavaScript"> window.location.href ="viewquiz.php" </script>';
                
                
            }
    }
    else{
        echo " Existed";
    }

}


?>
</table>
<br>
<a href="viewquiz.php">Return</a>

<?php
mysql_close($link);
?>
