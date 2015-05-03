 <?php
    session_start();
    include '../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Question</title>
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
</head>
<body>
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="viewquiz.php">Quiz</a></li>
    <li class="active">Quiz Info</li>
    </ol>
    
    <?php
        $qid = intval($_GET['qid']);
        $query_count    = "SELECT count(*) FROM question WHERE quizid = $qid";
        $result_count   = mysql_query($query_count, $link);
        $count = mysql_result($result_count, 0);

        $query_select = "SELECT * FROM quiz WHERE quizid = '$qid'";
        $result_select = mysql_query($query_select, $link);
        while($m_rows = mysql_fetch_object($result_select)){
            $m_quizname     = $m_rows->quizname;
            $m_lessonid     = $m_rows->lessonid;
            $m_createtime   = $m_rows->created_on;
            $m_creator      = $m_rows->created_by;
            $m_modifytime   = $m_rows->modified_on;
            $m_modifier     = $m_rows->modified_by;
        }
?>
    <div align = "right">Total Questions:<font color="red"><?php echo $count; ?></font>&nbsp<a class = " btn btn-default" href="add_question_2.php?qid=<?php echo $qid ?>">Add Question</a>&nbsp<a class = " btn btn-default" href="select_question.php?qid=<?php echo $qid ?>">Select Question</a>
    <hr>
        <table id="question" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <th align="right">Question ID</th>
        <th align="right">Content</th>
        <th align="right">Difficulty</th>
        <th align="right">Modify</th>
        <th align="right">Delete</th>
        </thead>
        <?php
            $query="select * from quiz_to_question where quizid = $qid";
            $result=mysql_query($query,$link);
            echo "<tbody>";
            while($a_rows=mysql_fetch_object($result))
            {


        $query_select_course = "SELECT * FROM course WHERE courseid = '$m_lessoncourse'";
        $result_select_course = mysql_query($query_select_course);
        while($m_rows = mysql_fetch_object($result_select_course)){
            $m_coursename = $m_rows->coursename;
        }
    ?>
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#quizDetail" aria-controls="quizDetail" role="tab" data-toggle="tab">
                    Quiz Detail
                </a>
            </li>
            <li role="presentation">
                <a href="#questionList" aria-controls="questionList" role="tab" data-toggle="tab">
                    Quiz Questions
                </a>
            </li>
        </ul>
    </div>

        ?>
                <tr>
                <td align="left" width="100"><?php echo $b_rows->questionid ?></a></td>
                <td align="left" width="500"><a href="question_info.php?quid=<?php echo $b_rows->questionid ?>&qid=<?php echo $qid ?>"><?php echo $b_rows->content ?></a></td>
                <td align="left" width="50"><?php echo $b_rows->difficulty ?></a></td>
                <td align="left" width="100"><a href="edit_question.php?quid=<?php echo $b_rows->questionid ?>&qid=<?php echo $qid ?>">Modify</a></td>
                <td align="left" width="100"><a href="del_ques.php?quesid=<?php echo $b_rows->questionid ?>&qid=<?php echo $qid ?>">Delete</a></td>
                </tr>                
        <?php
            }
            
            ?>
            </center>
            <script>
            $(document).ready(function(){
            $('#question').DataTable(
                {     
                    "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
                });
            });
            </script>
        </div>
    </div>
    </body>
    </html>