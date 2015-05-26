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
    $query3 = " SELECT * from user where userid = $uid";
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
     <!-- jquery UI -->
    <!-- Added on: 11-04-15 -->
    <script src="../jqueryui/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script src="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.css">
       
</head>
<body>
     <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li class="active">Question List</li>
    </ol>

    <center>
    <?php
        
        $query_count="SELECT count(*) from question";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        
    ?>

    <div align = "right">Total Questions:<font color="red"><?php echo $count; ?></font>&nbsp
        <a id="addbutton" class = " btn btn-default" href="add_question.php">
            <img src="../img/addquestion_white.png">
            Add Question
        </a>
    <hr>
        <table id="question" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <th align="right">Content</th>
        <th align="right">Course</th>
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
                    $query="SELECT * from question WHERE course_id = '".$permrows->courseid."'";
                    $result=mysql_query($query,$link)or die(mysql_error());
                    echo "<tbody>";
                    while($a_rows=mysql_fetch_object($result))
                    {

        ?>
                        <tr>
                        <td align="left" width="500"><a href="question_info_2.php?quid=<?php echo $a_rows->questionid ?>"><?php echo htmlspecialchars_decode($a_rows->content) ?></a></td>
                         <td align="left" width="50"><?php echo $a_rows->course_name ?></a></td>
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
            }
            else
            {
                $query="SELECT * from question ";
                    $result=mysql_query($query,$link);
                    echo "<tbody>";
                    while($a_rows=mysql_fetch_object($result))
                    {

        ?>
                        <tr>
                       
                        <td align="left" width="500"><a href="question_info_2.php?quid=<?php echo $a_rows->questionid ?>"><?php echo htmlspecialchars_decode($a_rows->content) ?></a></td>
                        <td align="left" width="50"><?php echo $a_rows->course_name ?></a></td>
                        <td align="left" width="40"><?php echo $a_rows->difficulty ?></a></td>
                        <td align="left" width="60">
                            <a class="action-tooltip" href="edit_question_2.php?quid=<?php echo $a_rows->questionid ?>" title="Modify Question">
                                <img id="action-icon" src="../img/modifyicon2_600x600.png">
                                <!-- Modify -->
                            </a>
                            <a class="action-tooltip" href="del_queslist.php?quesid=<?php echo $a_rows->questionid ?>" title="Delete Question">
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
                    null,
                    { "bSortable": false }
                ]
            });
        });
    </script>
    </body>
    </html>