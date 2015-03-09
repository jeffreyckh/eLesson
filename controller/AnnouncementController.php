<?php
include('../inc/db_config.php');
class AnnouncementController
{
	
// Add annoucement database controller
  public function addAnnounce($taskname,$taskdate)
  {
    $query = "INSERT INTO announcement(taskname,taskdate) VALUES ('$taskname',now())";
    $result = mysql_query($query)  or die ('Error updating database: ' . mysql_error());
    if($result)
    {
      echo "suecess!!";
<<<<<<< HEAD
      header('Location:testingHome.php');
=======
      header('Location:announcement.php');
>>>>>>> origin/kit
    }
    else
    {
      echo "Add announcement failed";
    }
  }

  public function count()
  {

     $query_count="select count(*) from annoucement";
     $result_count=mysql_query($query_count);
     $count=mysql_result($result_count);
    
  }
<<<<<<< HEAD
=======

>>>>>>> origin/kit
}

?>