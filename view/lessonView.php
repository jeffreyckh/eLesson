<?php
include ('../inc/db_config.php');
class lessonView{
	
	public function delLesson()
	{
		if(isset($_POST['submit']))
			{
				if(isset($_POST['lessonname']))
				{
					$lid = intval($_POST['lid']);
					$lessonname=$_POST['lessonname'];
					$check = "select * from lesson where lessonid = $lid";
					$check_result = mysql_query($check);	
					while($m_rows=mysql_fetch_object($check_result))
    				{
       					$m_directionid=$m_rows->direction_id;
   			 		}

						$dsql="delete from lesson where lessonid = $lid";
						$dresult = mysql_query($dsql);
						$sql1 = "select * from quiz where lessonid = $lid";
						$result1  = mysql_query($sql1);
							while($m_rows=mysql_fetch_object($result1))
							{
    							$quizid=$m_rows->quizid;
    							$dsql1="delete from quiz where quizid = $quizid";
    							$dresult1 = mysql_query($dsql1);
    							$sql2 = "select * from question where quizid = $quizid";
								$result2  = mysql_query($sql2);
								while($m_rows=mysql_fetch_object($result2))
								{
    								$questionid=$m_rows->questionid;
    								$dsql2="delete from quiz_to_question where questionid = $questionid";
    								$dresult = mysql_query($dsql2);
								}
							}


						if(!$dresult && !$dresult1 && !$dresult2 && !$dresult3)
							die("Could not update the data!".mysql_error());
						else
						{
							echo '<script> alert("Delete Lesson Successful!") </script>';
							echo '<script language="JavaScript"> window.location.href ="courses_info.php?cid='.$m_directionid.'" </script>'; 
                 			
						}
					
				}

			}
	}

		public function delviewLesson()
		{
		if(isset($_POST['submit']))
			{
				if(isset($_POST['lessonname']))
				{
					$lid = intval($_POST['lid']);
					$lessonname=$_POST['lessonname'];
					$flag = false;
					$check = "select * from lesson";
					$check_result = mysql_query($check);	
					while($result_rows=mysql_fetch_object($check_result))
					{
						$courseid = $result_rows->direction_id;
					}

						$dsql="delete from lesson where lessonid = $lid";
						$dresult = mysql_query($dsql);
						$sql1 = "select * from quiz where lessonid = $lid";
						$result1  = mysql_query($sql1);
							while($m_rows=mysql_fetch_object($result1))
							{
    							$quizid=$m_rows->quizid;
    							$dsql1="delete from quiz where quizid = $quizid";
    							$dresult1 = mysql_query($dsql1);
    							$sql2 = "select * from question where quizid = $quizid";
								$result2  = mysql_query($sql2);
								while($m_rows=mysql_fetch_object($result2))
								{
    								$questionid=$m_rows->questionid;
    								$dsql2="delete from quiz_to_question where questionid = $questionid";
    								$dresult = mysql_query($dsql2);
								}
							}
						if(!$dresult && !$dresult1 && !$dresult2 && !$dresult3)
							die("Could not update the data!".mysql_error());
						else
						{
							echo '<script language="JavaScript"> window.location.href ="viewlesson.php" </script>'; 
                 			echo '<script> alert("Delete Lesson Successful!") </script>';
						}
					
				}

			}
		}
}