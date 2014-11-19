<?php
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
    <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Courses</title>
  <!--<link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />-->
</head>
<body>
    <center>
    <?php
        $query_count="select count(*) from course";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);

        
    ?>

    <script>
    function show_popup() {
        var p = window.createPopup()
        var pbody = p.document.body
        pbody.style.backgroundColor = "lime"
        pbody.style.border = "solid black 1px"
        pbody.innerHTML = "This is a pop-up! Click outside to close."
        p.show(150,150,200,50,document.body)
    }

    </script>

<!--<a href="edit_courses.php" onclick="javascript:void window.open('edit_courses.php','1414934651699','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Pop-up Window</a>-->
    <table>
    <tr>
    <td align="right">
    Total Courses:<font color="red"><?php echo $count; ?></font>|<a href="add_courses.php">Add New Course</a>
    </td>
    <tr><td>
        <table>
        <th align="right">Course ID</th><th align="right">Course Name</th><th align="right">Created</th><th align="right">Modify</th><th align="right">Delete</th>
        <?php
            $query="select * from course order by courseid";
            $result=mysql_query($query,$link);
            while($a_rows=mysql_fetch_object($result))
            {
        ?>
                <tr>
                <td align="right" width="100"><?php echo $a_rows->courseid ?></a></td>
                <td align="right" width="100"><a href="courses_info.php?cid=<?php echo $a_rows->courseid ?>"><?php echo $a_rows->coursename ?></a></td>

                <td align="right" width="100"><?php echo $a_rows->created ?></td>
                <td align="right" width="100"><a href="edit_courses.php?cid=<?php echo $a_rows->courseid ?>">Modify</a></td>
                <td align="right" width="100"><a href="delete_courses.php?cid=<?php echo $a_rows->courseid ?>">Delete</a></td>
                </tr>                
        <?php
            }
                mysql_close($link);
        ?>
        <tr><br>
            <td align="right" colspan="6"><br>
            <form action="search.php" method="post">
                Select Check:
                    <select name="select">
                        <option value="courseid" selected>Course ID</option>
                        <option value="coursename">Course Name</option>
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
    </center>
    </body>
    </html>