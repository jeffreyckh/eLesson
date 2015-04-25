<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
require_once('../view/announcementView.php');
$announcement = new announcementView();
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
  </head>
<body>
  <div class = "col-md-8">
    <legend>Navigation</legend>
    <div class = "row">
      <div class = "col-md-5">
        <div id="piechart" style="width: 100%; height: 100%;"></div>
      </div>
      <div class = "col-md-5">
        <div id="columnchart_values" style="width: 100%; height: 100%;"></div>
      </div>
      <div class = "col-md-5">
        <div id="chart_div" style="width: 100%; height: 100%;"></div>
      </div>
    </div>
  <div class = "col-md-3">
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
</div>
<?php
  $cname = array();
  $cview = array();
  $courseresult = mysql_query("SELECT * FROM course") or die(mysql_error());
  while($c_rows = mysql_fetch_object($courseresult))
  {
    $cname[] = $c_rows->coursename;
    $cview[] = $c_rows->view;
  }
  $csize = count($cname);
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

      google.load("visualization", "1", {packages:["corechart", "bar",'gauge']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        // pie Chart for passing ate
        var data = google.visualization.arrayToDataTable([
          ['PassFail', 'Number of people'],
          ['Pass',    <?php echo $pass?>],
          ['Fail',    <?php echo $fail?>]
        ]);
        // bar chart for number of view
        var cdata = google.visualization.arrayToDataTable([
          ['Course', 'View'],
          <?php 
          for($i = 0;$i < $csize;$i++)
          {
          ?>
          [ '<?php echo $cname[$i]?>' , <?php echo $cview[$i];?>],   
          <?php }?>
         ]);
        
        // gauge for total user registered
        var tudata = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['User', <?php echo $numUserRows; ?>]
        ]);

        var options = {
          title: 'Passing Rate'
        };
        var coptions = {
          chart: {
            title: 'Number of Course View',
          }
        };
        var tuoptions = {
          width: 400, height: 120,
          redFrom: 900, redTo: 1000,
          yellowFrom:750, yellowTo: 900,
          minorTicks: 10
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        var cchart = new google.charts.Bar(document.getElementById('columnchart_values'));
        var tuchart = new google.visualization.Gauge(document.getElementById('chart_div'));

        
        chart.draw(data, options);
        cchart.draw(cdata, coptions);
        tuchart.draw(tudata, tuoptions);
      }
    </script>
   
    </script>
</body>
</html>