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
					$flag = false;
					$check = "select * from course";
					$check_result = mysql_query($check);	
					while($result_rows=mysql_fetch_object($check_result))
					{
						$courseid = $result_rows->direction_id;
						if(strcmp($coursename,$result_rows->coursename)!=0)
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
						$sql="delete from course where courseid = $cid";
						$lsql="delete from lesson where direction_id = $cid";
						$result = mysql_query($sql);
						$lresult = mysql_query($lsql);
						if(!$result && !$lresult)
							die("Could not update the data!".mysql_error());
						else
						{
							echo '<script language="JavaScript"> window.location.href ="courses.php" </script>'; 
                 			echo '<script> alert("Delete Course Successful!") </script>';
						}
					}
				}

			}
		}
}
?>