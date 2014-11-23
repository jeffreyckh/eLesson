<?php
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    $m_id=intval($_GET['cid']);
    $query="select coursename,description from course where courseid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_coursename=$m_rows->coursename;
        $m_coursedesc=$m_rows->description;
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
    <li><a href="courses.php">Courses</a></li>
    <li class="active">Course Info</li>
    </ol>

<div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#courseDetail" aria-controls="courseDetail" role="tab" data-toggle="tab">Course Detail</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="courseDetail">
            <table class="table table-bordered">
            <tr>
                <td>Course Name:</td><td><?php echo $m_coursename ?></td>
            </tr>
            <tr>
                <td>Course Description:</td><td><?php echo $m_coursedesc ?></td>
            </tr>
            </table>
            </div>
        <div role="tabpanel" class="tab-pane" id="profile">
            ...
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
