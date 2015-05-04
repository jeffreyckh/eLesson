<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
require_once('../view/announcementView.php');
$announcement = new announcementView();
$time = time();
$month=date("F",$time);
$year=date("Y",$time);

$mysqltesting = "UPDATE dashboard SET $month = $month + 1 WHERE title = 'userview'" or die(mysql_error());
$testresutl = mysql_query($mysqltesting);
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
  </head>
<body>
  <div class = "col-md-8">
    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#piechart" aria-controls="home" role="tab" data-toggle="tab">Passing Rate</a></li>
        <li role="presentation"><a href="#columnchart_values" aria-controls="profile" role="tab" data-toggle="tab">Number of view</a></li>
        <li role="presentation"><a href="#chart_div" aria-controls="messages" role="tab" data-toggle="tab">Total registered member</a></li>
      
        </ul>
    <!--<div class = "row">
      <div class = "col-md-5">
        <div id="piechart" style="width: 100%; height: 100%;"></div>
      </div>
      <div class = "col-md-20">
        <div id="columnchart_values" style="width: 900px%; height: 400px;"></div>
      </div>
      <div class = "col-md-5">
        <div id="chart_div" style="width: 100%; height: 100%;"></div>
      </div>!-->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="piechart"></div>
      <div role="tabpanel" class="tab-pane" id="columnchart_values"></div>
      <div role="tabpanel" class="tab-pane" id="chart_div"></div>
    </div>
    </div>
  </div>
 <!--<div class = "col-md-3">
  <div class = "row">
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
</div>
</div>!-->

<?php

  $cname = array();
  $cview = array();
  $lname = array();
  $lview = array();
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
      $lcompleteresult = mysql_query("SELECT * FROM lessoncomplete where lessonid ='".$l_rows->lessonid."'") or die(mysql_error());
      $lcompleterows = mysql_num_rows($lcompleteresult);
      $lview[] = $lcompleterows;
    }
    $_SESSION['lename'] = $lname;
    $_SESSION['leview'] = $lview;
  }
  //$jcname = json_encode($cname);
  //$jcview = json_encode($cview);
  $passquery = mysql_query("SELECT pass FROM passingrate") or die(mysql_error());
  $pass = mysql_result($passquery,0);
  $failquery = mysql_query("SELECT fail FROM passingrate") or die(mysql_error());
  $fail = mysql_result($failquery,0);
  $nuquery = mysql_query("SELECT * FROM user");
  $numUserRows = mysql_num_rows($nuquery);
?>
<!--Pie Chart !-->

<script type="text/javascript">
      //$('#myTab a').click(function (e) {
      //e.preventDefault()
      //$(this).tab('show')
      //})

      
      </script>
      <script type="text/javascript">
      function passingRateChart()
      {
        // pie Chart for passing ate
          var data = google.visualization.arrayToDataTable([
            ['PassFail', 'Number of people'],
            ['Pass',    <?php echo $pass?>],
            ['Fail',    <?php echo $fail?>]
          ]);
       
          var options = {
            title: 'Passing Rate'
          };
       

          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
           function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            alert('The user selected ' + topping);
          }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler);
        
          chart.draw(data, options);
        }
        google.load('visualization', '1', {
        packages: ['corechart'],
        callback: passingRateChart
        });
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
          chart: {
            title: 'Number of Course View',
          }
        };
      
        var cchart = new google.charts.Bar(document.getElementById('columnchart_values'));
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
        packages: ['bar'],
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