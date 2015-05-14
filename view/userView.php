<?php
include('../inc/db_config.php');

class userView
{
   public function editAcc()
   {
    if (isset($_POST['submit']))
    {

      if (isset($_POST['rank']))
      {
        $userid=intval($_POST['userid']);
        $rank = $_POST['rank'];

            $sql="update user set rank='$rank' where userid=$userid";
            if(!mysql_query($sql))
             die("Could not update the data!".mysql_error());
            else
            {
               echo '<script> alert("Modify User Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="manageAccount.php" </script>'; 
                 
            }
          }
      }


  }

  public function delAcc()
  {
     if (isset($_POST['submit']))
    {
      if (isset($_POST['username']))
      {
        $userid=intval($_POST['userid']);
        $username=$_POST['username'];
        
   
            $sql="delete from user where userid=$userid";
            if(!mysql_query($sql))
             die("Could not update the data!".mysql_error());
            else
            {
               echo '<script> alert("Delete Account Successful!") </script>';
                echo '<script language="JavaScript"> window.location.href ="manageAccount.php" </script>'; 
                 
            }
          
      }
    }
  }

  public function reminderMailSent()
  {
    if(isset($_POST['sendReminder']))
    {
      echo '<script> alert("Reminder Mail was sent!") </script>';
      echo '<script language="JavaScript"> window.location.href ="manageAccount.php" </script>'; 
    }
  }

}