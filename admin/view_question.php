 <?php
    session_start();
    $urank = $_SESSION['rank'];
    if ($urank == 3)
    {
      echo '<script language="javascript">';
      echo 'alert("You have no permission to access here")';
      echo '</script>';
      
      header("Location: ../user/userHome.php");
      die();
    }
    include'../inc/db_config.php';
    include '../inc/header.php';
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
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Question</title>
  <!--<link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />-->
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css">
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
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="viewquiz.php">Quiz</a></li>
    <li class="active">Question</li>
    </ol>
    <center>
    <?php
        $qid = intval($_GET['qid']);
        $query_count="select count(*) from quiz_to_question where quizid = $qid";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>

    <div align = "right">Total Questions:<font color="red"><?php echo $count; ?></font>&nbsp
        <a id="addbutton" class = " btn btn-default" href="add_question_2.php?qid=<?php echo $qid ?>">
            <img src="../img/addquestion_white.png">
            Add Question
        </a>&nbsp
        <a id="addbutton" class = " btn btn-default" href="select_question.php?qid=<?php echo $qid ?>">
            <img src="../img/selectquestion_white.png">
            Select Question
        </a>
    <hr>

        <table id="question" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <th align="right">Content</th>
        <th align="right">Difficulty</th>
        <th align="right">Action</th>
        <!-- <th align="right">Modify</th>
        <th align="right">Delete</th> -->
        </thead>
        <?php
            $query="select * from quiz_to_question where quizid = $qid order by questionid asc";
            $result=mysql_query($query,$link);
            echo "<tbody>";
            while($a_rows=mysql_fetch_object($result))
            {

                $query2="select * from question where questionid=$a_rows->questionid";
                $result2 = mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2))
                {

        ?>
                <tr>
                <td align="left" width="500"><a href="question_info.php?quid=<?php echo $b_rows->questionid ?>&qid=<?php echo $qid ?>"><?php echo htmlspecialchars_decode($b_rows->content) ?></a></td>
                <td align="left" width="50"><?php echo $b_rows->difficulty ?></a></td>
                <!-- <td align="left" width="100"><a href="edit_question.php?quid=<?php echo $b_rows->questionid ?>&qid=<?php echo $qid ?>">Modify</a></td>
                <td align="left" width="100"><a href="del_ques.php?quesid=<?php echo $b_rows->questionid ?>&qid=<?php echo $qid ?>">Delete</a></td> -->
                <td align="left" width="100">
                            <a class="action-tooltip" href="edit_question.php?quid=<?php echo $b_rows->questionid ?>&qid=<?php echo $qid ?>" title="Modify Question">
                                <img id="action-icon" src="../img/modifyicon2_600x600.png">
                                <!-- Modify -->
                            </a>
                            <a class="action-tooltip" href="del_ques.php?quesid=<?php echo $b_rows->questionid ?>&qid=<?php echo $qid ?>" title="Delete Question">
                                <img id="action-icon" src="../img/deleteicon2_600x600.png">
                                <!-- Delete -->
                            </a>
                        </td>
                </tr>                
        <?php
            }
            }
            
                mysql_close($link);
        ?>
    </tbody> 
    </table>
    </center>
    <script>
    var tool = $.noConflict(true);
    $(document).ready(function(){
        $('#question').DataTable(
            {    
                "fnDrawCallback": function()
                {
                    tool(function()
                    {
                      tool( ".action-tooltip" ).tooltip(
                      {
                        show: {
                          effect: false
                        },
                        position: {
                            my: "center top-25",
                            at: "center top-20"
                        },
                        show: false,
                        hide: 
                            false
                        
                      });
                    });
                },
                "columnDefs": [
                {
                    /*"targets": [ 0 ],
                    "visible": false,
                    "searchable": false*/

                }],   
                "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">',
                stateSave: true,
                "aoColumns": [
                    null,
                    null,
                    { "bSortable": false }
                ]
            });
        });


    </script>
    </body>
    </html>