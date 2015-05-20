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
    <li class="active">Feedback Form</li>
    </ol>

    <div align = "center">
    <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#viewfeedback" aria-controls="home" role="tab" data-toggle="tab">Feedback Sent</a></li>
    <li role="presentation"><a href="#sendfeedback" aria-controls="profile" role="tab" data-toggle="tab">Send Feedback</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="viewfeedback">
        <table id="feedback" class="table table-striped table-bordered" cellspacing="0" >
        <thead>    
        <th align="left">Type</th>
        <th align="left">Title</th>
        <th align="left">Date</th>
        </thead>
        <?php
        $fbquery= "SELECT * FROM feedback where sender_id = $uid and feedback_category != 'Reply'";
        $fbresult = mysql_query($fbquery) or die (mysql_error());
        while($fb_rows=mysql_fetch_object($fbresult))
        {
            $fbid= $fb_rows->feedbackid;
          $senderid = $fb_rows->sender_id;
          $username = $fb_rows->sender_name;
          $fbtype = $fb_rows->feedback_category;
          $fbtitle = $fb_rows->feedback_title;
          $fbdate = $fb_rows->date;
        ?>
        <tbody>
          <tr>
            <td><?php echo $fbtype; ?></td>
            <td align="left"><a href="feedbackdetail.php?fbid=<?php echo $fbid ?>&fbtitle=<?php echo $fbtitle ?>"><?php echo $fbtitle ?></a></td>
            <td><?php echo $fbdate?></td>
          </tr>
        </tbody>
        <?php
          }
          echo "</table>";
        ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="sendfeedback">
        
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
        <?php
            if(isset($_POST['sendFeedbackForm']))
            {
                $dt = date("Y-m-d H:i:s");
                $category = $_POST['ddlFeedbackCategory'];
                $title = $_POST['feedbacktitle'];
                $content = $_POST['feedbackcontent'];

                $fbInfo="insert into feedback(date,feedback_category,feedback_title,feedback_content,sender_id,sender_name) values('$dt','$category','$title','$content','$uid','$uname')";
                if(!mysql_query($fbInfo))
                {
                    die("Unable to store the feedback into database.".mysql_error());
                }
            }
        ?>
    </form>
    </div>

  </div>

</div>
</div> 
<script type="text/javascript">
   $('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
    </script>
    <script>
$(document).ready(function(){
    $('#feedback').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});
</script>
    </body>
    </html>