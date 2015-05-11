<?php
session_start();
$urank = $_SESSION['rank'];
if ($urank == 3)
{
  echo '<script language="javascript">';
  echo 'alert("You have no permission to access here")';
  echo '</script>';
  
  header("Location: ../user/userHome.php");
  die();
}
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
require_once('../view/announcementView.php');
$announcement = new announcementView();

      $time = time();
      $month=date("F",$time);
      $year=date("Y",$time);
      $totalviewer = 0;
      $userstack = array();
      $adminstack = array();
      $coursestack = array();
      $coursemodstack = array();

      $coursequery = "select * from course order by view desc";
     $courseresult = mysql_query($coursequery,$link);
      while($b_rows=mysql_fetch_object($courseresult))
      {
      array_push($coursestack,$b_rows->coursename,$b_rows->view);

      }

      $coursequery2 = "select * from course order by mod_time desc";
      $courseresult2 = mysql_query($coursequery2);
      while($d_rows = mysql_fetch_object($courseresult2))
      {

        array_push($coursemodstack,$d_rows->coursename,$d_rows->mod_time);
      }

   

        
      $querycheck = "select * from user_view";
      $checkresult = mysql_query($querycheck);
       while($c_rows=mysql_fetch_object($checkresult))
    {
      $totalviewer = $totalviewer + $c_rows->$month; 

      if($c_rows->usertype == 1 || $c_rows->usertype == 2)

      {
        array_push($adminstack,$c_rows->username,$c_rows->$month);
      }

      else
      {
         array_push($userstack,$c_rows->username,$c_rows->$month);
      }
       
    }

     
 

 $usercount =count($userstack);
 $admincount = count($adminstack);
 if($usercount < 11){
    for($i = 0;$i < (10-$usercount);$i++)
    {
        array_push($userstack,'null','null');
    }
}

if($admincount < 11){
    for($i = 0;$i < (10-$admincount);$i++)
    {
        array_push($adminstack,'null','null');
    }
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Home</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <!--Script required for Google chart !-->
    <script type="text/javascript" src="../jscss/googleChart.js"></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="../jscss/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="../jscss/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    
    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <link rel="stylesheet" href="../jscss/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    
    <link rel="stylesheet" href="../jscss/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    <script type="text/javascript" src="../jscss/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
     <script type="text/javascript"> 
   $(function () {
   $('[data-toggle="popover"]').popover()
    })
     </script>
  </head>
  <body>
  <div class = "col-md-8">

      <div  id="piechart" style="width: 900px; height: 500px;"></div>
  </div>
 <div class = "col-md-3">
  <!--<div class = "row">
   <br> <hr>
  <?php
  include "../inc/calender.php";
  ?>
  <br></br>
    <div class = "row">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Announcement
            </a>
          </h4>
        </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <fieldset class = "setright">
              <?php
                  $query="select * from announcement order by taskid DESC limit 1";
                  $result=mysql_query($query);
                  while($a_rows=mysql_fetch_object($result))
                  {
                  echo "<fieldset>
                     Posted On:".$a_rows->taskdate."
                     <br></br>
                     Annoucement:".$a_rows->taskname."
                     </fieldset>";
                    echo "<hr>";
                  }
              ?>      
            </fieldset> 
        </div>
      </div>
      </div>
    </div>
  </div>
</div>!-->
<div class = "row">
<br>
<button type="button" class="btn btn-lg btn-danger"  style="width: 250px; height: 60px;" data-html = "true" >Monthly Viewers <br> <?php echo $totalviewer ?></button>
<br>
<button type="button" class="btn btn-lg btn-danger"  style="width: 250px; height: 60px;" data-html = "true" data-toggle="popover" title="Top 5 User" data-content="1:<?php echo $userstack[0]; ?> <br>2:<?php echo $userstack[2]; ?> <br>3:<?php echo $userstack[4]; ?><br>4:<?php echo $userstack[6]; ?><br>5:<?php echo $userstack[8]; ?>">Most Active User <br> <?php echo $userstack[0]; ?> </button>
<br>
</div>

<div class = "row">
<button type="button" class="btn btn-lg btn-danger"  style="width: 250px; height: 60px;" data-html = "true" data-toggle="popover" title="Top 5 Admin" data-content="1:<?php echo $adminstack[0]; ?><br>2:<?php echo $adminstack[2]; ?><br>3:<?php echo $adminstack[4]; ?><br>4:<?php echo $adminstack[6]; ?><br>5:<?php echo $adminstack[8]; ?>">Most Active Admin <br>  <?php echo $adminstack[0]; ?></button>
<br>
<button type="button" class="btn btn-lg btn-danger"  style="width: 250px; height: 60px;" data-html = "true" data-toggle="popover" title="Top 5 Course" data-content="1:<?php echo $coursemodstack[0]; ?><br>2:<?php echo $coursemodstack[2]; ?><br>3:<?php echo $coursemodstack[4]; ?><br>4:<?php echo $coursemodstack[6]; ?><br>5:<?php echo $coursemodstack[8]; ?>">Most Change Course <br> <?php echo $coursemodstack[0]; ?></button>
</div>
<div class = "row">
<button type="button" class="btn btn-lg btn-danger"  style="width: 250px; height: 60px;" data-html = "true" data-toggle="popover" title="Top 5 Viewed" data-content="1:<?php echo $coursestack[0]; ?><br>2:<?php echo $coursestack[2]; ?><br>3:<?php echo $coursestack[4]; ?><br>4:<?php echo $coursestack[6]; ?><br>5:<?php echo $coursestack[8]; ?>">Most View Course <br> <?php echo $coursestack[0]; ?> <br> <?php echo $coursestack[1] ?> Views</button>
<br>
<button type="button" class="btn btn-lg btn-danger"  style="width: 250px; height: 60px;" data-html = "true" data-toggle="popover" title="Top 5 Scorer" data-content="1:xia0t99<br>2:user<br>3:null<br>4:null<br>5:null">Top Scorer <br>xia0t99<br>Average Score:100</button>
</div>
</div>

<?php

  $cname = array();
  $cview = array();
  $lname = array();
  $lview = array();
  $lcomp = array();
  $lincomp = array();
  $courseresult = mysql_query("SELECT * FROM course") or die(mysql_error());
  while($c_rows = mysql_fetch_object($courseresult))
  {
    $cname[] = $c_rows->coursename;
    $cview[] = $c_rows->view;
  }
  $csize = count($cname);
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $coursename = $_GET['q'];
    //$clessonquery = "SELECT courseid FROM course WHERE coursename ='" . $coursename . "'";
    $clessonresult = mysql_query("SELECT courseid FROM course WHERE coursename ='" . $coursename . "'") or die(mysql_error());
    $directid = mysql_result($clessonresult,0);
    $lessonresult  = mysql_query("SELECT * FROM lesson WHERE direction_id ='" . $directid . "'") or die(mysql_error());
    while($l_rows = mysql_fetch_object($lessonresult))
    {
      $lname[] = $l_rows->lessonname;
      $lviewresult = mysql_query("SELECT * FROM lessoncomplete where lessonid ='".$l_rows->lessonid."'") or die(mysql_error());
      $lviewrows = mysql_num_rows($lviewresult);
      $lview[] = $lviewrows;
      $lcompleteresult = mysql_query("SELECT * FROM lessoncomplete where complete = '1' AND lessonid ='".$l_rows->lessonid."'") or die(mysql_error());
      $lcompleterows = mysql_num_rows($lcompleteresult);
      $lcomp[] = $lcompleterows;
      $lincomp[] = $lviewrows - $lcompleterows;
    }
    $_SESSION['lename'] = $lname;
    $_SESSION['leview'] = $lview;
    $_SESSION['lecomp'] = $lcomp;
    $_SESSION['leincomp'] = $lincomp;
  }
  //$jcname = json_encode($cname);
  //$jcview = json_encode($cview);
  $nuquery = mysql_query("SELECT * FROM user");
  $numUserRows = mysql_num_rows($nuquery);
?>
<!--Pie Chart !-->

      <script type="text/javascript">
     $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      })
      function numberCourseView()
      {

        
        // bar chart for number of view
        var cdata = google.visualization.arrayToDataTable([
          ['Course', 'View'],
          <?php 
          for($i = 0;$i < $csize;$i++)
          {
          ?>
          ['<?php echo $cname[$i]?>',<?php echo $cview[$i];?>],   
          <?php }?>
         ]);
        
        var coptions = {
            title: 'Number of Course View',
        };
      
        var cchart = new google.visualization.PieChart(document.getElementById('piechart'));
        function cselectHandler() {
          var cselectedItem = cchart.getSelection()[0];
          if (cselectedItem) {
            var ctopping = cdata.getValue(cselectedItem.row, 0);
            $.ajax ({
                url: "adminHome.php",
                data: 'q=' + ctopping,
                 success: function(data) {
                  
                $.fancybox.open([
                  {
                    href : 'chart/lessonChart.php', 
                    'width'  : 900,           // set the width
                    'height' : 600,
                    type : 'iframe',
                    padding : 5
                  }
                
                ], {
                  padding : 0   
                  });
                }
            });
          }
        }

        google.visualization.events.addListener(cchart, 'select', cselectHandler);
       
        cchart.draw(cdata, coptions);
      
      }
      google.load('visualization', '1', {
        packages: ['corechart'],
        callback: numberCourseView
      });
      function numberofUser()
      {

        // gauge for total user registered
        var tudata = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['User', <?php echo $numUserRows; ?>]
        ]);

        var tuoptions = {
          width: 400, height: 120,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

    
        var tuchart = new google.visualization.Gauge(document.getElementById('chart_div'));

        tuchart.draw(tudata, tuoptions);
      
      }
      google.load('visualization', '1', {
        packages: ['gauge'],
        callback: numberofUser
      });
    </script>
<?php 

?>
</body>
</html>