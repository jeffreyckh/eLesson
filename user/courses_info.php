<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    $m_id=intval($_GET['cid']);
    $uid = $_SESSION['userid'];

    $querycheck = "select * from lessonstatus where userid = $uid and courseid = $m_id";
    $checkresult = mysql_query($querycheck);
        

        if(mysql_num_rows($checkresult) == 0)
        {
          $sql = "INSERT INTO lessonstatus (userid, courseid)
            VALUES ('$uid', '$m_id')";
            mysql_query($sql,$link);
        }
          
        
       


    $uquery = "select * from permission where userid = $uid and courseid = $m_id";
    $uresult = mysql_query($uquery);
    if(mysql_num_rows($uresult) != 0)
    {
        echo '<script language="JavaScript"> window.location.href ="../admin/courses_info.php?cid='.$m_id.'" </script>'; 
    }
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
  <meta name="keywords" content="Course info">
  <meta name="description" content="Course and lesson">
  <title>Course Info</title>
    <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
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
    <li><a href="courses.php">Courses</a></li>
    <li class="active">Course Info</li>
    </ol>
<div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#courseDetail" aria-controls="courseDetail" role="tab" data-toggle="tab">Course Detail</a></li>
    <li role="presentation"><a href="#lessons" aria-controls="lessons" role="tab" data-toggle="tab">Lessons</a></li>
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
        <div role="tabpanel" class="tab-pane" id="lessons">
        <?php
        $c_id=intval($_REQUEST['cid']);
        $userid = $_SESSION['userid'];
        $lessonquery = "select lessoncount from lessonstatus where userid = $userid and courseid = $c_id";
        $lessonresult = mysql_query($lessonquery,$link);
        $lessoncount = mysql_result($lessonresult,0);
        ?>

        <table id = "lesson" class="table table-striped table-bordered" cellspacing="0">
        <thead>
            <tr>
            <th align="left">Lesson ID</th>
            <th align="left">Lesson Name</th>
            <th align="left">Created</th>
            </tr>
            </thead>

        <?php
            $lquery="select * from lesson where direction_id=$c_id limit $lessoncount";
            $lresult=mysql_query($lquery,$link);
            echo "<tbody>";
            while($a_rows=mysql_fetch_object($lresult))
            {
        ?>
            
                <tr>
                <td align="left" width="100"><?php echo $a_rows->lessonid ?></a></td>
                <td align="left" width="100"><a href="lessons_info.php?lid=<?php echo $a_rows->lessonid ?>"><?php echo $a_rows->lessonname ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->created ?></td>
                </tr>
                           
        <?php
            }
                //mysql_close($link);
        ?>
        </tbody> 
        </td>
        </tr>
        </table>

    </div>
</div>

<?php
}
mysql_close($link);
?>

<script>
$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
<script>
$(document).ready(function(){
    $('#lesson').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});
</script>
</body>
</html>
