<?php
include('../inc/db_config.php');

class userView{
   public function editAcc(){
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
               
                echo '<script language="JavaScript"> window.location.href ="manageAccount.php" </script>'; 
                 echo '<script> alert("Modify User Successful!") </script>';
            }
          }
      }
  }
}

  ?>