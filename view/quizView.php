<?php
include('../inc/db_config.php');

class quizView
{
	public function delQuiz()
	{
		if(isset($_POST['submit']))
			{
				if(isset($_POST['quizname']))
				{

					$quizid = intval($_POST['quizid']);
					$quizname=$_POST['quizname'];
					$check = "select * from quiz";
					$check_result = mysql_query($check);	

						$sql="delete from quiz where quizid = $quizid";
						$lsql="delete from question where quizid = $quizid";
						$qqsql="delete from quiz_to_question where quizid = $quizid";
						$result = mysql_query($sql);
						$lresult = mysql_query($lsql);
						$lresult = mysql_query($qqsql);
						if(!$result && !$lresult)
							die("Could not update the data!".mysql_error());
						else
						{
							echo '<script language="JavaScript"> window.location.href ="viewquiz.php" </script>'; 
                 			echo '<script> alert("Delete quiz Successful!") </script>';
						}
					
				}

			}
		}
}
?>