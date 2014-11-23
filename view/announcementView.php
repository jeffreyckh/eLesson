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

  public function editAnnouncement(){
    if (isset($_POST['submit']))
    {
      if (isset($_POST['taskname']))
      {
        $taskid=intval($_POST['taskid']);
        $taskname=$_POST['taskname'];
        $announce_controller = new AnnouncementController();
        $flag=true;
        $check="select * from announcement";
        $check_result=mysql_query($check);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(strcmp($taskname,$result_rows->taskname)!=0)
            $flag=false;
            else
            $flag=true;
        }
    
        if($flag==false)
          {
            $sql="update announcement set taskname='$taskname' where taskid=$taskid";
            if(!mysql_query($sql))
             die("Could not update the data!".mysql_error());
            else
            {
               
                echo '<script language="JavaScript"> window.location.href ="announcement.php" </script>'; 
                 echo '<script> alert("Modify Announcement Successful!") </script>';
            }
          }
      }
    }
  }
  public function delAnnouncement()
  {
     if (isset($_POST['submit']))
    {
      if (isset($_POST['taskname']))
      {
        $taskid=intval($_POST['taskid']);
        $taskname=$_POST['taskname'];
        $announce_controller = new AnnouncementController();
        $flag=true;
        $check="select * from announcement";
        $check_result=mysql_query($check);
        while($result_rows=mysql_fetch_object($check_result))
        {
            if(strcmp($taskname,$result_rows->taskname)!=0)
            $flag=false;
            else
            $flag=true;
        }
    
        if($flag==false)
          {
            $sql="delete from announcement where taskid=$taskid";
            if(!mysql_query($sql))
             die("Could not update the data!".mysql_error());
            else
            {
               
                echo '<script language="JavaScript"> window.location.href ="announcement.php" </script>'; 
                 echo '<script> alert("Modify Announcement Successful!") </script>';
            }
          }
      }
    }
  }
}
?>
