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
    
    $m_id         = intval($_GET['l_hid']);
    $query        = "SELECT lessonname, lessoncontent, direction_id 
                      FROM lesson_history WHERE lesson_hist_id = $m_id";
    $query_select = "SELECT * FROM lesson_history WHERE lesson_hist_id ='$m_id'";
    $result       = mysql_query($query_select, $link);
    while($m_rows = mysql_fetch_object($result))
    {
        $m_lessonname     = $m_rows->lessonname;
        $m_lessoncontent  = $m_rows->lessoncontent;
        $courseid         = $m_rows->direction_id;

        $m_create_time  = $m_rows->created_on;
        $m_creator      = $m_rows->created_by;
        $m_modify_time  = $m_rows->modified_on;
        $m_modifier     = $m_rows->modified_by;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Course Info</title>
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
  <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="courses.php">Courses</a></li>
    <li><a href="courses_info.php?cid=<?php echo $courseid?>">Course Info</a></li>
    <li class="active">Lesson Info</li>
    </ol>

<div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#lessonDetail" aria-controls="lessonDetail" role="tab" data-toggle="tab">Lesson Content</a></li>
    <li role="presentation"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Lesson Info</a></li>
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="lessonDetail">
          <h1>Lesson Name:<?php echo $m_lessonname ?></h1>
          <hr>
          <h2>Lesson Content:</h2>
            <fieldset><?php echo $m_lessoncontent ?></fieldset>    
        </div>
        <div role="tabpanel" class="tab-pane" id="info">
          <table class="table table-bordered">
            <tr>
              <td>Lesson Name:</td>
              <td><?php echo $m_lessonname; ?></td>
            </tr>
            <tr>
              <td>Created By:</td>
              <td><?php echo $m_creator; ?></td>
            </tr>
            <tr>
              <td>Created On:</td>
              <td><?php echo $m_create_time; ?></td>
            </tr>
            <tr>
              <td>Last Modified By:</td>
              <td><?php echo $m_modifier; ?></td>
            </tr>
            <tr>
              <td>Last Modified On:</td>
              <td><?php echo $m_modify_time; ?></td>
            </tr>
          </table>
        </div>
</div>

<?php
}
mysql_close($link);
?>
</table>
<script>
$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>

</body>
</html>
