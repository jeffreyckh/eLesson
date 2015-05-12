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
    $urank = $_SESSION['rank'];
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
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>   
</head>
<body>
     <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li class="active">Question List</li>
    </ol>

    <center>
    <?php
        
        $query_count="select count(*) from question";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>

    <div align = "right">Total Questions:<font color="red"><?php echo $count; ?></font>&nbsp<a class = " btn btn-default" href="add_question.php">Add Question</a>
    <hr>
        <table id="question" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <th align="right">Question ID</th>
        <th align="right">Content</th>
        <th align="right">Difficulty</th>
        <th align="right">Action</th>

        </thead>
        <?php
            if($urank == 2)
            {
                $select_perm = "SELECT * FROM permission WHERE userid = $uid";
                $permresult = mysql_query($select_perm);
                while($permrows = mysql_fetch_object($permresult))
                {
                    $query="select * from question WHERE course_id = '".$permrows->courseid."'";
                    $result=mysql_query($query,$link)or die(mysql_error());
                    echo "<tbody>";
                    while($a_rows=mysql_fetch_object($result))
                    {

        ?>
                        <tr>
                        <td align="left" width="100"><?php echo $a_rows->questionid ?></a></td>
                        <td align="left" width="500"><a href="question_info_2.php?quid=<?php echo $a_rows->questionid ?>"><?php echo $a_rows->content ?></a></td>
                        <td align="left" width="50"><?php echo $a_rows->difficulty ?></a></td>
                        <td align="left" width="100">
                            <a href="edit_question_2.php?quid=<?php echo $a_rows->questionid ?>">
                                <img id="action-icon" src="../img/modifyicon2_600x600.png">
                                <!-- Modify -->
                            </a>
                            <a href="del_queslist.php?quesid=<?php echo $a_rows->questionid ?>">
                                <img id="action-icon" src="../img/deleteicon2_600x600.png">
                                <!-- Delete -->
                            </a>
                        </td>
                        </tr>                
        <?php
                    }
                    $query2="select * from question WHERE course_id <> '".$permrows->courseid."'";
                    $result2=mysql_query($query2,$link);
                    echo "<tbody>";
                    while($a2_rows=mysql_fetch_object($result2))
                    {

        ?>
                        <tr>
                        <td align="left" width="100"><?php echo $a2_rows->questionid ?></a></td>
                        <td align="left" width="500"><a href="question_info_2.php?quid=<?php echo $a2_rows->questionid ?>"><?php echo $a2_rows->content ?></a></td>
                        <td align="left" width="50"><?php echo $a2_rows->difficulty ?></a></td>
                        <td align="left" width="100">
                        </tr>                
        <?php
                    }
                }
            }
            else
            {
                $query="select * from question";
                    $result=mysql_query($query,$link);
                    echo "<tbody>";
                    while($a_rows=mysql_fetch_object($result))
                    {

        ?>
                        <tr>
                        <td align="left" width="100"><?php echo $a_rows->questionid ?></a></td>
                        <td align="left" width="500"><a href="question_info_2.php?quid=<?php echo $a_rows->questionid ?>"><?php echo $a_rows->content ?></a></td>
                        <td align="left" width="50"><?php echo $a_rows->difficulty ?></a></td>
                        <td align="left" width="100">
                            <a href="edit_question_2.php?quid=<?php echo $a_rows->questionid ?>">
                                <img id="action-icon" src="../img/modifyicon2_600x600.png">
                                <!-- Modify -->
                            </a>
                            <a href="del_queslist.php?quesid=<?php echo $a_rows->questionid ?>">
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
    $(document).ready(function(){
    $('#question').DataTable(
        {     
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
    });
    </script>
    </body>
    </html>