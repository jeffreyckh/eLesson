 <?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    $uid = $_SESSION['userid'];
    $quizID = intval($_GET['qid']);
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="quiz">
  <meta name="description" content="quiz">
  <title>Quiz</title>
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
    <li class="active">QuizResult</li>
    </ol>

    <center>
    
    <?php 
        $quizresult = mysql_query("SELECT * FROM passingrate WHERE userid = $uid AND quizid = $quizID") or die (mysql_error());
        $quizresult2 = mysql_query("SELECT * FROM user_to_quiz WHERE userid = $uid AND quizid = $quizID") or die(mysql_error());
        while($a_rows = mysql_fetch_object($quizresult))
        {

            while($b_rows=mysql_fetch_object($quizresult2))
            {
                $starttime = $b_rows->start_time;
                $finishtime = $b_rows->finish_time;
                $attempttime = $b_rows->attempt;

            }

            
            echo 'Your result for this quiz is ' . $a_rows->result . '<br>';
            echo 'Start Time: ' . $starttime . '<br>';
            echo 'Finish Time: ' . $finishtime . '<br>';
            echo 'Attempt Time: ' . $attempttime . '<br>';

        }
    ?>




    </center>
    <script>
    $(document).ready(function(){
    $('#quiz').DataTable(
        {  
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
    });
    </script>
    </body>
    </html>