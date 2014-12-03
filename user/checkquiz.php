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
      
        
        for ($x = 1; $x <= $count; $x++) {
        	$selection = $_POST['radioselection'.$x];
            $query = "select * from question";
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
        
        }


		}

		$wrong = $count - $score;
		echo 'You Get ' . $score . ' question correct and ' . $wrong . ' question wrong!'

    ?>

<table>
        <tr><br>
            <td align="center" colspan="6"><br>
           <a href="user_viewquiz.php">Return</a>
        </td>        
        </tr>    
    </table>