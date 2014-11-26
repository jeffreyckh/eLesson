 <?php
    include'../inc/db_config.php';
    include '../inc/header.php';
    //include 'adminNav.php';
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
        $query_count="select count(*) from quiz";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>


    <table>
    <tr>

    <tr><td>
        <table class="table table-bordered">
        <th align="left">Quiz ID</th><th align="left">Quiz Name</th><th align="left">Created</th><th align="left">Lesson</th><th align="left">Course</th>
        <?php
            $query="select * from quiz order by lessonid";
            //$query2="select * from course";
            $result=mysql_query($query,$link);
            //$result2=mysql_query($query2,$link);
           
            while($a_rows=mysql_fetch_object($result))
            {

                $query2="select * from lesson";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {
                    if($a_rows->lessonid == $b_rows->lessonid)
                    {
                        $lessonname = $b_rows->lessonname;
                        $directionid = $b_rows->direction_id;

                            $query3="select * from course";
                            $result3=mysql_query($query3,$link);
                            while($c_rows=mysql_fetch_object($result3))
                            {
                                if($directionid == $c_rows->courseid)
                                {
                                $coursename = $c_rows->coursename;
                                }
                
                            }

                    }          
                
                }


        ?>
                <tr>
                <td align="left" width="100"><?php echo $a_rows->quizid ?></a></td>
                <td align="left" width="100"><a href="user_doquiz.php?qid=<?php echo $a_rows->quizid ?>"><?php echo $a_rows->quizname ?></a></td>
                <td align="left" width="100"><?php echo $a_rows->created ?></td>
                <td align="left" width="100"><?php echo $lessonname ?></td>
                 <td align="left" width="100"><?php echo $coursename ?></td>
              
                </tr>                
        <?php

            }
                mysql_close($link);
        ?>
        <tr><br>
            <td align="left" colspan="6"><br>
            <form action="search.php" method="post">
                Select Check:
                    <select name="select">
                        <option value="quizid" selected>Quiz ID</option>
                        <option value="quizname">Quiz Name</option>
                        <option value="createdate">Created Date</option>
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

