<?php
session_start();
$lname = $_SESSION['lename'];
$lview = $_SESSION['leview'];
$lsize = count($lname);
?>
<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  	<script type="text/javascript">
    /*google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
          ['Course', 'View'],
          <?php 
          for($i = 0;$i < $lsize;$i++)
          {
          ?>
          ['<?php echo $lname[$i]?>' , <?php echo $lview[$i];?>],   
          <?php }?>
         ]);

    	var options = {
          chart: {
            title: 'Number of Course View',
          }
        };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(data, options);
  }*/

    function numberLessonView()
      {

        
        // bar chart for number of view
        var data = google.visualization.arrayToDataTable([
          ['Lesson', 'Completed'],
          <?php 
          for($i = 0;$i < $lsize;$i++)
          {
          ?>
          [ '<?php echo $lname[$i]?>' , <?php echo $lview[$i];?>],   
          <?php }?>
         ]);
        
        var options = {
          chart: {
            title: 'Number of Lesson Completed',
          }
        };
      
        var chart = new google.charts.Bar(document.getElementById('columnchart_values'));
        
       
        chart.draw(data, options);
      
      }
      google.load('visualization', '1', {
        packages: ['bar'],
        callback: numberLessonView
      });

  </script>
  <body>
	<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
</body>
</html>