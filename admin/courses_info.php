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
                <?php
        $c_id=intval($_REQUEST['cid']);
        $query_count="select count(*) from lesson where direction_id=$c_id";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>


    <table>
    <tr>
    <td align="right">
    Total Lesson:<font color="red"><?php echo $count; ?></font>|<a href="add_lessons.php?cid=<?php echo $c_id?>">Add New Lesson</a>
    </td>
    <tr><td>
        <table class="table table-bordered">
        <th align="right">Lesson ID</th><th align="right">Lesson Name</th><th align="right">Created</th><th align="right">Modify</th><th align="right">Delete</th>
        <?php
            $lquery="select * from lesson where direction_id=$c_id";
            $lresult=mysql_query($lquery,$link);
            while($a_rows=mysql_fetch_object($lresult))
            {
        ?>
                <tr>
                <td align="right" width="100"><?php echo $a_rows->lessonid ?></a></td>
                <td align="right" width="100"><a href="lessons_info.php?lid=<?php echo $a_rows->lessonid ?>"><?php echo $a_rows->lessonname ?></a></td>

                <td align="right" width="100"><?php echo $a_rows->created ?></td>
                <td align="right" width="100"><a href="edit_lessons.php?lid=<?php echo $a_rows->lessonid ?>">Modify</a></td>
                <td align="right" width="100"><a href="delete_lessons.php?lid=<?php echo $a_rows->lessonid ?>">Delete</a></td>
                </tr>                
        <?php
            }
                //mysql_close($link);
        ?>
        <tr><br>
            <td align="right" colspan="6"><br>
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
        </td>        
    </tr>    
    </table>
    </td>
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
