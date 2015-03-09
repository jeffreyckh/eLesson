 <?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    $qid = intval($_REQUEST['qid']);
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
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="viewquiz.php">Quiz</a></li>
    <li><a href="view_question.php?qid=<?php echo $qid?>">Question</a></li>
    <li class="active">Question Info</li>
    </ol>

    <center>
    <?php
        $quid = intval($_GET['quid']);
        $qid = intval($_REQUEST['qid']);
        $query="select * from question where questionid = $quid";
        $result=mysql_query($query,$link);

             while($a_rows=mysql_fetch_object($result))
            { 

        ?>
 
        <table class="table table-bordered">
            <tr>
                <td>Current Question:</td><td><?php echo $a_rows->content ?></td>
            </tr>
           <!-- <tr>
                <td>Choice Type:</td><td><?php 
                if($a_rows->choicetype == 'radio')
                    {$choicetype = 'Single Choice';}
                else
                    {$choicetype = 'Multiple Choice';}


                echo $choicetype

                ?></td> 
            </tr> -->
            <tr>
                <td>Option List:</td><td><?php 

                $optionstring = $a_rows->optionlist;
                $optiontoken = strtok($optionstring, "/");

                while ($optiontoken !== false)
                {
                echo "$optiontoken<br>";
                $optiontoken = strtok("/");
                } 

                ?></td>
            </tr>
               <tr>
                <td>Answer:</td><td><?php 

                $answerstring = $a_rows->answer;
                $token = strtok($answerstring,"/");

                while ($token !== false)
                {
                echo "$token<br>";
                $token = strtok("/");
                } 
                ?></td>
            </tr>
            </table>
        
            
        

        <?php
            
            }
            
                mysql_close($link);
        ?>
    </table>
    </td>
    </tr>
    </table>
    </center>
    </body>
    </html>