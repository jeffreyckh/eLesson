 <?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    $uid = $_SESSION['userid'];
    $query = " select * from user where userid = $uid";
    $result = mysql_query($query);
    while($rows=mysql_fetch_object($result))
    {
        $uname = $rows->username;
    }
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>Feedback Form</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>   
</head>
<body>
    <ol class="breadcrumb">
    <li><a href="userHome.php">Home</a></li>
    <li><a href="feedback.php">Feedback</a></li>
    <li class="active">Feedback Form</li>
    </ol>
<form action="" method="post">
        <table class="table table-bordered">
        <tr>
            <td width="20%" >User Name: </td><td><?php echo $uname ?></td>
        </tr>
        <tr>
            <td width="20%">Feedback Category: </td>
            <td>
                <select name="ddlFeedbackCategory">
                    <option value="" selected></option>
                    <option value="Bug Reports">Bug Reports</option>
                    <option value="Report Lesson Content">Report Lesson Content</option>
                    <option value="Report Quiz">Report Quiz</option>
                    <option value="Technical / Web Support">Technical / Web Support</option>
                    <option value="Requests">Requests</option>
                    <option value="Suggestion">Suggestion</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="20%">Title: </td><td><input type="text" name="feedbacktitle"></td>
        </tr>
        <tr>
            <td width="20%">Feedback Content: </td><td><textarea name = "feedbackcontent" rows="5" cols="100"></textarea></td>
        </tr>
    </table>
        <input class="btn btn-default" type="submit" name="sendFeedbackForm" value="Send Feedback Form">
        </form>
        <?php
            if(isset($_POST['sendFeedbackForm']))
            {
                $dt = date("Y-m-d H:i:s");
                $category = $_POST['ddlFeedbackCategory'];
                $title = $_POST['feedbacktitle'];
                $content = $_POST['feedbackcontent'];

                $nInfo="insert into notification(type,receiver_id,date,message,readnotification,sender_id,sender_name) values('Feedback','0','$dt','$content','0','$uid','$uname')";
                $nresult = mysql_query($nInfo) or die (mysql_error());
                $fbInfo="insert into feedback(date,feedback_category,feedback_title,feedback_content,sender_id,sender_name) values('$dt','$category','$title','$content','$uid','$uname')";
                if(!mysql_query($fbInfo))
                {
                    die("Unable to store the feedback into database.".mysql_error());
                }
                echo '<script> alert("Feedback was submiited!") </script>';
                echo '<script language="JavaScript"> window.location.href ="feedback.php" </script>';   
            }
        ?>
    
</body>
</html>