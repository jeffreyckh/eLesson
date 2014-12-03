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
					$flag = false;
					$check = "select * from quiz";
					$check_result = mysql_query($check);	
					while($result_rows=mysql_fetch_object($check_result))
					{
						$courseid = $result_rows->direction_id;
						if(strcmp($quizname,$result_rows->quizname)!=0)
						{
							$flag = false;
						}	

						else
						{	

							$flag= true;

						}

					}
					if($flag== true)
					{
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
}
?>