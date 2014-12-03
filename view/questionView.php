<?php
include ('../inc/db_config.php');
class questionView
{
public function delQuestion()
	{
		if(isset($_POST['submit']))
			{
				if(isset($_POST['content']))
				{
					$quesid = intval($_POST['quesid']);
					$lessonname=$_POST['content'];	

						$sql="delete from question where questionid = $quesid";
						$qqsql = "delete from quiz_to_question where questionid = $quesid";
						if(!mysql_query($sql))
							die("Could not update the data!".mysql_error());
						else
						{
							$result = mysql_query($qqsql);
							echo '<script> alert("Delete Question Successful!") </script>';
							echo '<script language="JavaScript"> window.location.href ="view_questionlist.php" </script>'; 
                 			
						}
					
				}

			}
	}


}