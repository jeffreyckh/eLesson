 <?php
    session_start();
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
        $qid = intval($_GET['qid']);
        $query_count="select count(*) from question where quizid = $qid";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>


    <table>
    <tr>
    <td align="right">
    Total Questions:<font color="red"><?php echo $count; ?></font>|<a href="add_question.php?qid=<?php echo $qid ?>">Add Question</a>
    </td>
    <tr><td>
        <table class="table table-bordered">
        <th align="right">Question ID</th><th align="right">Content</th><th align="right">Modify</th><th align="right">Delete</th>
        
        <?php
            $query="select * from question where quizid = $qid";
            $result=mysql_query($query,$link);
           
            while($a_rows=mysql_fetch_object($result))
            {

              

        ?>
                <tr>
                <td align="left" width="100"><?php echo $a_rows->questionid ?></a></td>
                <td align="left" width="500"><a href="question_info.php?quid=<?php echo $a_rows->questionid ?>&qid=<?php echo $qid ?>"><?php echo $a_rows->content ?></a></td>
                
                <td align="left" width="100"><a href="edit_question.php?quid=<?php echo $a_rows->questionid ?>">Modify</a></td>
                <td align="left" width="100"><a href="delete_question.php?quid=<?php echo $a_rows->questionid ?>">Delete</a></td>
                </tr>                
        <?php
            }
            
                mysql_close($link);
        ?>
        <tr><br>
            <td align="center" colspan="6"><br>
           <a href="viewquiz.php">Return</a>
        </td>        
    </tr>    
    </table>
    </td>
    </tr>
    </table>
    </center>
    </body>
    </html>