<?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    $m_id=intval($_REQUEST['lid']);
    $uid = $_SESSION['userid'];
        if(!isset($_SESSION['lessonview']))
    {
        $viewquery = "UPDATE lesson SET view = view + 1 where lessonid = $m_id";
        $viewresult = mysql_query($viewquery);
        $_SESSION['lessonview'] = 1;
    }

   $querycheck = "select * from lessoncomplete where userid = $uid and lessonid = $m_id";
    $checkresult = mysql_query($querycheck);
        

        if(mysql_num_rows($checkresult) == 0)
        {

          $starttime = date('Y-m-d H:i:s');

          $sql = "INSERT INTO lessoncomplete (userid, lessonid,complete,start_time)
            VALUES ('$uid', '$m_id','0','$starttime')";
            mysql_query($sql,$link);
        }
          


    
    $vquery = " select * from user_to_lesson where userid = $uid and lessonid = $m_id";
    $vresult = mysql_query($vquery);
    $numrows = mysql_num_rows($vresult);
     $time = date("Y-m-d H:i:s");
    $myViewTime = DateTime::createFromFormat('Y-m-d H:i:s', $time);
    //echo $numrows;
    while($v_rows = mysql_fetch_object($vresult))
    {
      $validuid = $v_rows->userid;
      $validlid = $v_rows->lessonid;
    }
  
    if( mysql_num_rows($vresult) == 0)
    {

      $uquery = "INSERT INTO user_to_lesson( userid, lessonid, viewtime) 
            VALUES ('$uid', '$m_id', '$time')";
      $uresult = mysql_query($uquery);
    }
    else
    { 
      $abquery = "UPDATE user_to_lesson SET viewtime='$time' WHERE userid=$uid and lessonid = $m_id";
       $abresult = mysql_query($abquery);
    }
        

    $query="select lessonname,lessoncontent,direction_id from lesson where lessonid=$m_id";
    $result=mysql_query($query,$link);
    while($m_rows=mysql_fetch_object($result))
    {
      $m_lessonname=$m_rows->lessonname;
      $m_lessoncontent=$m_rows->lessoncontent;
      $courseid = $m_rows->direction_id;
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="lesson">
  <meta name="description" content="lessons content">
  <title>Course Info</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
  <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
</head>
<body>
  <ol class="breadcrumb">
    <li><a href="userHome.php">Home</a></li>
    <li><a href="courses.php">Courses</a></li>
    <li><a href="courses_info.php?cid=<?php echo $courseid?>">Course Info</a></li>
    <li class="active">Lesson Info</li>
    </ol>


  <!-- Tab panes -->
<div>
          <div id="lesson_container">
          <h1><center><?php echo $m_lessonname ?></center></h1>
          <hr>
          
            <fieldset><?php echo $m_lessoncontent ?></fieldset>    
          </div>

          
            <?php
        if(isset($_GET['action'])=='donelesson') {
            donelesson();
          }else
          //show form
          ?>

          <table class = "table table-bordered">
          <tr>
          <form action="?action=donelesson" method="post">
          <input type="hidden" type="text" name="cid" value="<?php echo $courseid ?>">
          <input type="hidden" type="text" name="lid" value="<?php echo $m_id ?>">
          </table>
          <?php 
        
           $querycheck = "select lessoncount from lessonstatus where userid = $uid and courseid = $courseid";
           $checkresult = mysql_query($querycheck);
           $currentcount = mysql_result($checkresult,0);
           $current_query = "select lessonid from lesson where direction_id = $courseid limit $currentcount";
           $current_result= mysql_query($current_query);
           $querylesson = "select count(*) from lesson where direction_id = $courseid";
           $lessonresult = mysql_query($querylesson);
           $lessontotal = mysql_result($lessonresult,0);


           if($currentcount <= $lessontotal)

          { $current_lesson = mysql_result($current_result,($currentcount - 1)); }

          else
          {
          $current_lesson = 0;
          }

            if($m_id == $current_lesson)
            {

            ?>
          
          <div align = "center" ><input class="btn btn-default" type="submit" value="Complete"></div>
            <?php 

           
          } 
            
            ?>
          </form>
        </div>
        </tbody> 
        </td>
        </tr>
        </table>

    </div>
</div> 

 
    <?php
        }
        mysql_close($link);
        ?>  

<script>
$(document).ready(function(){
    $('#lesson').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});

</script>


</body>
</html>


  <?php

           function donelesson() 
          {

          include'../inc/db_config.php';
           $done_courseid=intval($_POST['cid']);
           $done_lessonid=intval($_POST['lid']);
            $uid = $_SESSION['userid'];
          $date = date('Y-m-d H:i:s');
          $flag=true;
         $done_query="SELECT lessoncount FROM lessonstatus WHERE userid = $uid AND courseid = $done_courseid";
          $done_result=mysql_query($done_query,$link);
          $newlc = mysql_result($done_result,0) + 1;

            $endtime = date('Y-m-d H:i:s');
          $flag=true;
         //$done_query="SELECT lessoncount FROM lessonstatus WHERE userid = $uid AND courseid = $done_courseid";
          //$done_result=mysql_query($done_query,$link);
          //$newlc = mysql_result($done_result,0) + 1;
          $finish = 1;


          $sql = "UPDATE lessoncomplete SET complete = '$finish', end_time = '$endtime' WHERE userid = $uid AND lessonid = $done_lessonid";

           if(!mysql_query($sql,$link))
           { die("Could not update the data!".mysql_error());}
           else
            {

                echo '<script> 
                    var answer = confirm("You had finished the lesson! Would you like to take the quiz?")
                      if(answer)
                      {
                        window.location.href ="user_viewquiz.php"
                     }
                      else
                      {
                       window.location.href ="userHome.php"                 
                     } 
                      </script>';
               
            }


          }
          ?>


