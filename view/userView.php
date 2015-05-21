<?php
include('../inc/db_config.php');

class userView
{
   public function editAcc()
   {
    if(isset($_POST['userid']))
    {
      $userid=intval($_POST['userid']);
    }
    if (isset($_POST['submit']))
    {
         if(isset($_POST['permCourse']))
            {
              $perm = $_POST['permCourse'];
              $query2 = "SELECT * from permission where userid = $userid";
              $result2 = mysql_query($query2);
              if (mysql_num_rows($result2) != 0) 
              {
                 $sql="DELETE from permission where userid=$userid";
                 $result3 = mysql_query($sql);
              } 
              
              if(!empty($perm))
              {
                $n = count($perm);
                for($i=0;$i < $n; $i++)
                {
                  $sql1 = "INSERT into permission (userid,courseid) values ($userid,$perm[$i])";
                  $result3 = mysql_query($sql1);
                  //echo($perm[$i] . " ");
                }
              }
            }
      if (isset($_POST['rank']))
      {
        
        $rank = $_POST['rank'];

        if($rank == 3)
        {
          $deletesql = "DELETE FROM permission WHERE userid = $userid";
          mysql_query($deletesql) or die(mysql_error());

        }

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