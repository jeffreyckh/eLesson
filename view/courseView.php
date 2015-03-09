<?php
include('../inc/db_config.php');

class courseView
{
	public function delCourse()
	{
		if(isset($_POST['submit']))
			{
				if(isset($_POST['coursename']))
				{
					$cid = intval($_POST['cid']);
					$coursename=$_POST['coursename'];
					
						$dsql="delete from course where courseid = $cid";
						$dresult = mysql_query($dsql);
						$sql1 = "select * from lesson where direction_id = $cid";
						$result1 = $lresult = mysql_query($sql1);
						while($m_rows=mysql_fetch_object($result1))
						{
    						$lessonid=$m_rows->lessonid;
    						$dsql1="delete from lesson where lessonid = $lessonid";
    						$dresult1 = mysql_query($dsql1);
    						$sql2 = "select * from quiz where lessonid = $lessonid";
							$result2  = mysql_query($sql2);
							while($m_rows=mysql_fetch_object($result2))
							{
    							$quizid=$m_rows->quizid;
    							$dsql2="delete from quiz where quizid = $quizid";
    							$dresult2 = mysql_query($dsql2);
    							$sql3 = "select * from question where quizid = $quizid";
								$result3  = mysql_query($sql3);
								while($m_rows=mysql_fetch_object($result3))
								{
    								$questionid=$m_rows->questionid;
    								$dsql3="delete from quiz_to_question where questionid = $questionid";
    								$dresult3 = mysql_query($dsql3);
								}
							}
						}
						
						if(!$dresult && !$dresult1 && !$dresult2 && !$dresult3)
							die("Could not update the data!".mysql_error());
						else
						{	
							echo '<script> alert("Delete Course Successful!") </script>';
							echo '<script language="JavaScript"> window.location.href ="courses.php" </script>'; 
                 			
						}
					}
				}

			}
		
}
?>