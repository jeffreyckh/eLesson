 <?php
    include'../inc/db_config.php';
    include '../inc/header.php';
    //include 'adminNav.php';
    ?>

        <?php
        $qid = intval($_GET['qid']);
        $query_count="select count(*) from question where quizid = $qid";
        $result_count=mysql_query($query_count,$link);
        $count=mysql_result($result_count,0);
        $query_name = "select quizname from quiz where quizid = $qid";
        $result_name = mysql_query($query_name,$link);
        $quizname = mysql_result($result_name,0);
        $score = 0;
        $wrong = 0;
       
        for ($x = 1; $x <= $count; $x++) {
        	$query = "select * from question where quizid = $qid";
        $result = mysql_query($query,$link);
        while($a_rows=mysql_fetch_object($result))
        {

        	//if($a_rows->choicetype == 'radio')
        	//{
        		$selection = $_POST['radioselection'.$x];
        	//}
        	//else
        	//{
        		//$selection = $_POST['checkboxselection'.[$x]];
        		//foreach($_POST['checkboxselection'.[$x]] as $selected){
				//echo $selected."</br>";
				//}
        	//}

        	if($selection == $a_rows->answer)
        	{
        		$score++;
        	}
        	else
        	{
        		$wrong++;
        	}
        }


		}

		echo 'You Get ' . $score . ' question correct and ' . $wrong . 'question wrong!'


    ?>