<?php
    session_start();
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
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../jscss/ckeditor/ckeditor.js"></script>
     <script type="text/javascript" src="../jscss/tablesorter/js/jquery.tablesorter.js"></script>
     <script src="../jscss/tablesorter/js/jquery.tablesorter.widgets.min.js"></script> 
</head>
<body>
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
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
        $query_count="select count(*) from lesson where direction_id=$c_id";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>

    Total Lesson:<font color="red"><?php echo $count; ?></font>|<a href="add_lessons.php?cid=<?php echo $c_id?>">Add New Lesson</a>
        <table id = "lesson" class="tablesorting">
        <thead>
            <tr>
            <th align="left">Lesson ID</th>
            <th align="left">Lesson Name</th>
            <th align="left">Created</th>
            <th align="left">Modify</th>
            <th align="left">Delete</th>
            </tr>
            </thead>

        <?php
            $lquery="select * from lesson where direction_id=$c_id";
            $lresult=mysql_query($lquery,$link);
            echo "<tbody>";
            while($a_rows=mysql_fetch_object($lresult))
            {
        ?>
            
                <tr>
                <td align="left" width="100"><?php echo $a_rows->lessonid ?></a></td>
                <td align="left" width="100"><a href="lessons_info.php?lid=<?php echo $a_rows->lessonid ?>"><?php echo $a_rows->lessonname ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->created ?></td>
                <td align="left" width="100"><a href="edit_lessons.php?lid=<?php echo $a_rows->lessonid ?>">Modify</a></td>
                <td align="left" width="100"><a href="delete_lessons.php?lid=<?php echo $a_rows->lessonid ?>">Delete</a></td>
                </tr>
                           
        <?php
            }
                //mysql_close($link);
        ?>
        </tbody> 
        </td>
        </tr>
        </table>
            <form action="search.php" method="post">
                Select Check:
                    <select name="select">
                        <option value="lessonid" selected>Lesson ID</option>
                        <option value="lessonname">Lesson Name</option>
                        <option value="createdate">Create Date</option>
                    </select>
                    Value: <input type="text" name="values">
                    <input type="submit" value="Check Total">
            </form>
     

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
<script>
$(document).ready(function(){
$(function(){
$("#lesson").tablesorter(
{
    theme : 'blue',
 
   // sortList : [[1,0],[2,0],[3,0]],
 
    // header layout template; {icon} needed for some themes
    headerTemplate : '{content}{icon}',
 
    // initialize column styling of the table
    widgets : ["columns"],
    widgetOptions : {
      // change the default column class names
      // primary is the first column sorted, secondary is the second, etc
      columns : [ "primary", "secondary", "tertiary" ]
    }
});
});
});
</script>
</body>
</html>
