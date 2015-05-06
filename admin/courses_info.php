<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    $m_id=intval($_GET['cid']);
    $uid = $_SESSION['userid'];
    $query3 = " select * from user where userid = $uid";
    $result3 = mysql_query($query3);
    while($rows=mysql_fetch_object($result3))
    {
        if($rows->rank == 2)
        {
            include '../inc/normalAdminNav.php';
        }
        else
        {
           include 'adminNav.php'; 
        }
    }
    $query="select coursename,description from course where courseid=$m_id";
    $query_select = "SELECT * FROM course WHERE courseid = $m_id";
    $result=mysql_query($query_select,$link);
    while($m_rows=mysql_fetch_object($result))
    {
        $m_coursename=$m_rows->coursename;
        $m_coursedesc=$m_rows->description;
        $m_course_createtime = $m_rows->created_on;
        $m_course_creator = $m_rows->created_by;
        $m_course_modifytime = $m_rows->modified_on;
        $m_course_modifier = $m_rows->modified_by;
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
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">

    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
     <!-- jquery UI -->
    <!-- Added on: 11-04-15 -->
    <script src="../jqueryui/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script src="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.css">
    
</head>
<body>
    <?php 
    $uid = $_SESSION['userid'];
    $query2 = " select * from user where userid = $uid";
    $result2 = mysql_query($query2);
    while($rows=mysql_fetch_object($result2))
    {
        if($rows->rank == 2)
        {
    ?>
    <ol class="breadcrumb">
    <li><a href="../user/userHome.php">Home</a></li>
    <li><a href="../user/courses.php">Courses</a></li>
    <li class="active">Course Info</li>
    </ol>
    <?php
        }
        else
        {
    ?>
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="courses.php">Courses</a></li>
    <li class="active">Course Info</li>
    </ol>
    <?php
        }
    }
    ?>
   
<div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#lessons" aria-controls="lessons" role="tab" data-toggle="tab">Course Lessons</a></li>
    <li role="presentation"><a href="#courseDetail" aria-controls="courseDetail" role="tab" data-toggle="tab">Course Detail</a></li>
  </ul>

  <!-- Tab panes -->
<div class="tab-content">
    
    <div role="tabpanel" class="tab-pane active" id="lessons">
                <?php
        $c_id=intval($_REQUEST['cid']);
        $query_count="select count(*) from lesson where direction_id=$c_id";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>

        <div align="right">Total Lesson:<font color="red"><?php echo $count; ?></font>&nbsp<a href="add_lessons.php?cid=<?php echo $c_id?>" class = "btn btn-default">Add New Lesson</a>
        <hr> 
            <table id = "lesson" class="table table-striped table-bordered" cellspacing="0">
            <thead>
                <tr>
                <th align="left">Lesson ID</th>
                <th align="left">Lesson Name</th>
                <th align="left">Created</th>
                <th align="left">Action</th>

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
                    <td align="left" width="100">

                        <a class="action-tooltip" href="edit_lessons.php?lid=<?php echo $a_rows->lessonid ?>" title="Modify">
                            <img id="action-icon" src="../img/modifyicon2_600x600.png">
                            <!-- Modify -->
                        </a>
                        <a class="action-tooltip" href="lesson_history.php?lid=<?php echo $a_rows->lessonid ?>" title="View History">
                            <img id="action-icon" src="../img/historyicon2_600x600.png">
                            <!-- &nbsp;View History&nbsp; -->
                        </a>
                        <a class="action-tooltip" href="del_lessons.php?lid=<?php echo $a_rows->lessonid ?>" title="Delete">
                            <img id="action-icon" src="../img/deleteicon2_600x600.png">
                            <!-- Delete -->
                        </a>
                    </td>
                    </tr>
                               
            <?php
                }
                    //mysql_close($link);
            ?>
            </tbody> 
            
            </table>

        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="courseDetail">
        <table class="table table-bordered">
        <tr>
            <td>Course Name:</td><td><?php echo $m_coursename ?></td>
        </tr>
        <tr>
            <td>Course Description:</td><td><?php echo $m_coursedesc ?></td>
        </tr>
        <tr>
            <td>Created By:</td>
            <td><?php echo $m_course_creator ?></td>
        </tr>
        <tr>
            <td>Created On:</td>
            <td><?php echo $m_course_createtime ?></td>
        </tr>
        <tr>
            <td>Last Modified By:</td>
            <td><?php echo $m_course_modifier ?></td>
        </tr>
        <tr>
            <td>Last Modified On:</td>
            <td><?php echo $m_course_modifytime ?></td>
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
<script>
function toolTip(){
        var jquery_1_11_4 = $.noConflict(true);
        jquery_1_11_4(function(){
          jquery_1_11_4( ".action-tooltip" ).tooltip({
            show: {
              effect: false
            }
          });
        });
    }
    $(document).ready(function(){
        $('#lesson').DataTable(
            { 
                "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
            });
        toolTip();
        $('.next').click(function(){
            toolTip();
        });
        $('.pagination').click(function(){
            toolTip();
        });
    });

    toolTip();
</script>
</body>
</html>
