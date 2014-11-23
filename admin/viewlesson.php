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
  <title>Home</title>
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
    <center>
    <?php
        $query_count="select count(*) from lesson";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>


    <table>
    <tr>
    <td align="right">
    Total Lesson:<font color="red"><?php echo $count; ?></font>|<a href="add_lessons2.php">Add New Lesson</a>
    </td>
    <tr><td>
        <table class="table table-bordered">
        <th align="right">Lesson ID</th><th align="right">Lesson Name</th><th align="right">Created</th><th align="right">Course</th><th align="right">Modify</th><th align="right">Delete</th>
        <?php
            $query="select * from lesson order by direction_id";
            //$query2="select * from course";
            $result=mysql_query($query,$link);
            //$result2=mysql_query($query2,$link);
           
            while($a_rows=mysql_fetch_object($result))
            {

                $query2="select * from course";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {
                    if($a_rows->direction_id == $b_rows->courseid)
                    {$cn = $b_rows->coursename;}

                
            }


        ?>
                <tr>
                <td align="right" width="100"><?php echo $a_rows->lessonid ?></a></td>
                <td align="right" width="100"><a href="lesson_info.php?lid=<?php echo $a_rows->lessonid ?>"><?php echo $a_rows->lessonname ?></a></td>
                <td align="right" width="100"><?php echo $a_rows->created ?></td>
                <td align="right" width="100"><?php echo $cn ?></td>
                <td align="right" width="100"><a href="edit_lessons.php?lid=<?php echo $a_rows->lessonid ?>">Modify</a></td>
                <td align="right" width="100"><a href="delete_lessons.php?lid=<?php echo $a_rows->lessonid ?>">Delete</a></td>
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
    </center>
    </body>
    </html>