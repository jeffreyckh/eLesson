 <?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="Conduct Quiz">
  <meta name="description" content="Conduct Quiz">
  <title>Conduct Quiz</title>
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
    <?php
        $qid = intval($_GET['qid']);
        $query_count="select count(*) from question where quizid = $qid";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        $query_name = "select quizname from quiz where quizid = $qid";
        $result_name = mysql_query($query_name,$link);
        $quizname = mysql_result($result_name,0);
        

    ?>


    <div align = "left"><h1>Quiz: <strong><?php echo $quizname ?></strong><h1></div>
    <hr>
    <form action="checkquiz.php?qid=<?php echo $qid?>" method="post">
    <?php
            $query="select * from quiz_to_question where quizid = $qid";
            $result=mysql_query($query,$link);
            $i = 0;
           
            while($a_rows=mysql_fetch_object($result))
            {


                $i++;
                $query2 = "select * from question where questionid = $a_rows->questionid";
                $result2=mysql_query($query2,$link);
                while($b_rows=mysql_fetch_object($result2)){
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>";
                echo $i . '.  ' . strip_tags($b_rows->content). '</br>' ;
                echo "</th>";
                echo "</tr>";
                if($b_rows->choicetype == 'radio')
                {
                    
                    $optionstring = $b_rows->optionlist;
                    $optiontoken = strtok($optionstring, "/");
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td>';
                    while ($optiontoken !== false)
                    {
                        $getvalue = $optiontoken;
                        $getvalue = str_replace(" ","-",$getvalue);
                    ?>
                    
                     <input type="radio" name="radioselection<?php echo $i?>"
                    <?php if (isset($radioselection{$i}) && $radioselection{$i}=="$optiontoken") echo "checked";?>
                    value=<?php echo $getvalue ?>  ><?php echo $optiontoken?>

                    <?php $optiontoken = strtok("/"); 
                    }
                    echo '</td>';
                    echo '</tr>'; 
                    echo '</tbody>';
                    echo '</table>';
                    
                    

                }
                else
                {

                     $optionstring = $b_rows->optionlist;
                    $optiontoken = strtok($optionstring, "/");

                    while ($optiontoken !== false)
                    {
                        
                    ?>
                    <input type="checkbox" name="checkboxselection[]<?php echo $i?>" value=<?php echo $optiontoken?> />

                    <?php
                    echo $optiontoken;
                    $optiontoken = strtok("/");
                    
                    }

                }


        

    ?>
        </br>
        </br>

        
        <?php
            }
            }
            
                mysql_close($link);
        ?>

     <input type="submit" value="Submit">
         </form>

    </body>
    </html>