 <?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    ?>

        <?php
        $qid = intval($_GET['qid']);
        $query_count="select count(*) from quiz_to_question where quizid = $qid";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        $score = 0;
        $wrong = 0;
        
        $questionnum = 1;
        
        $query2 = "select * from quiz_to_question where quizid = $qid";
        $result2 = mysql_query($query2,$link);
        while($b_rows=mysql_fetch_object($result2))
        {
            $selection = $_POST['radioselection'.$questionnum];
             $query = "select * from question where questionid = $b_rows->questionid";
            $result = mysql_query($query,$link);
     
            while($a_rows=mysql_fetch_object($result))
            {

            //if($a_rows->choicetype == 'radio')
            //{
                //$selection = $_POST['radioselection'.$x];
            //}
            //else
            //{
                //$selection = $_POST['checkboxselection'.[$x]];
                //foreach($_POST['checkboxselection'.[$x]] as $selected){
                //echo $selected."</br>";
                //}
            //}

            $answer = $a_rows->answer;
            $selection = str_replace("-"," ",$selection);
            if( strcmp ($selection,$answer) == 0 )
                {
                ++$score;
                break;
                }
            else
                {
                echo '<table>';
                echo '<tr>';
                echo '<td>Question No ' .$questionnum . ': ' . strip_tags($a_rows->content) .'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>Wrong answer. Your answer is: ' .$selection  .'.</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo 'Correct answer:' .$a_rows->answer . '.';
                echo '</td>';
                echo '</tr>';
                echo '</table>';
                echo '<br>';
                break;
                }
        
            }
            $questionnum++;
        }
   

		$wrong = $count - $score;
		echo 'You Get ' . $score . ' question correct and ' . $wrong . ' question wrong!';

    ?>

<table>
        <tr><br>
            <td align="center" colspan="6"><br>
           <a href="user_viewquiz.php">Return</a>
        </td>        
        </tr>    
    </table>