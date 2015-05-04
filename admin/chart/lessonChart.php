<?php
session_start();
$lname = $_SESSION['lename'];
$lview = $_SESSION['leview'];
$lcomp = $_SESSION['lecomp'];
$lincomp = $_SESSION['leincomp'];
$lsize = count($lname);
?>
<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  	<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart","bar"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
       var data = google.visualization.arrayToDataTable([
          ['Lesson', 'View'],
          <?php 
          for($i = 0;$i < $lsize;$i++)
          {
          ?>
          [ '<?php echo $lname[$i]?>' , <?php echo $lview[$i];?>],   
          <?php }?>
         ]);

       var cdata = google.visualization.arrayToDataTable([
          ['Lesson', 'Completed', 'Incomplete'],
          <?php 
          for($i = 0;$i < $lsize;$i++)
          {
          ?>
          [ '<?php echo $lname[$i]?>' , <?php echo $lcomp[$i];?>, <?php echo $lincomp[$i];?>],   
          <?php }?>
         ]);
        
        var options = {
        title: 'Lesson View',
        };

        var coptions = {
        title: 'Lesson status',
        };
      
        var chart = new google.visualization.PieChart(document.getElementById('columnchart_values'));
        var cchart = new google.charts.Bar(document.getElementById('columnchart_status'));
        
       
        chart.draw(data, options);
        cchart.draw(cdata, coptions);
  }

    /*function numberLessonView()
      {

        
        // bar chart for number of view
        var data = google.visualization.arrayToDataTable([
          ['Lesson', 'View'],
          <?php 
          for($i = 0;$i < $lsize;$i++)
          {
          ?>
          [ '<?php echo $lname[$i]?>' , <?php echo $lview[$i];?>],   
          <?php }?>
         ]);
        
        var options = {

        title: 'Lesson View',
        };
      
        var chart = new google.visualization.PieChart(document.getElementById('columnchart_values'));
        
       
        chart.draw(data, options);
      
      }
      google.load('visualization', '1', {
        packages: ['corechart'],
        callback: numberLessonView
      });*/


      /*function numberLessonstatus()
      {

        
        // bar chart for number of view
        var cdata = google.visualization.arrayToDataTable([
          ['Lesson', 'Completed', 'Incomplete'],
          <?php 
          for($i = 0;$i < $lsize;$i++)
          {
          ?>
          [ '<?php echo $lname[$i]?>' , <?php echo $lcomp[$i];?>, <?php echo $lincomp[$i];?>],   
          <?php }?>
         ]);
        
        var coptions = {

        title: 'Lesson status',
        };
      
        var cchart = new google.charts.Bar(document.getElementById('columnchart_status'));
        
       
        cchart.draw(cdata, coptions);
      
      }
      google.load('visualization', '1', {
        packages: ['bar'],
        callback: numberLessonstatus
      });*/

  </script>
  <body>
	<div id="columnchart_values" style="width: 600px; height: 500px;" align="center"></div>
  <hr>
  <div id="columnchart_status" style="width: 600px; height: 500px;" align="center"></div>
</body>
</html>