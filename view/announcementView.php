<?php
include('../inc/db_config.php');
include ('../controller/AnnouncementController.php');

class announcementView{
  

  function addAnnouncement(){
    if (isset($_POST['submit'])){
    if (isset($_POST['taskname'])){
    $announce_controller = new AnnouncementController(); 
    $taskname=$_POST['taskname'];
    $taskdate=$_POST['taskdate'];
    $announce_controller->addAnnounce($taskname,$taskdate);
    
    }
  } 
  }
}
?>
