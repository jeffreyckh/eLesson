<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    //include 'adminNav.php';
    $m_id=intval($_REQUEST['qid']);
    $query="select quizname,lessonid from quiz where quizid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_quizname=$m_rows->quizname;
        
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
    <li><a href="viewquiz.php">Quiz</a></li>
    <li class="active">Edit Quiz</li>
    </ol>

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
    $qid=intval($_POST['qid']);
    $m_id=intval($_POST['select']);
    //$m_did = intval($POST['cid']);
    $edit_name=$_POST['qname'];
    $flag=true;
    $check="select * from quiz";
    $check_result=mysql_query($check,$link);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(strcmp($edit_name,$result_rows->quizname)!=0)
            $flag=false;
            else
            $flag=true;
        }
    
    if($flag==false)
    {
       
            $sql="update quiz set quizname='$edit_name',lessonid='$m_id' where quizid=$qid";
            if(!mysql_query($sql,$link))
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
