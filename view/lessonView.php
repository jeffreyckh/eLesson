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
					$flag = false;
					$check = "select * from lesson";
					$check_result = mysql_query($check);	
					while($result_rows=mysql_fetch_object($check_result))
					{
						$courseid = $result_rows->direction_id;
						if(strcmp($lessonname,$result_rows->lessonname)!=0)
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
						$sql="delete from lesson where lessonid = $lid";
						if(!mysql_query($sql))
							die("Could not update the data!".mysql_error());
						else
						{
							echo '<script language="JavaScript"> window.location.href ="courses_info.php?cid='.$courseid.'" </script>'; 
                 			echo '<script> alert("Delete Lesson Successful!") </script>';
						}
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
						if(strcmp($lessonname,$result_rows->lessonname)!=0)
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
						$sql="delete from lesson where lessonid = $lid";
						if(!mysql_query($sql))
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
}