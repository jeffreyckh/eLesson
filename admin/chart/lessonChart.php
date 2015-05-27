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
    <link rel="stylesheet" href="../home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../../jscss/ckeditor/ckeditor.js"></script>
    <!--Script required for Google chart !-->
    <script type="text/javascript" src="../../jscss/googleChart.js"></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="../../jscss/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="../../jscss/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <script type="text/javascript" src="../../jscss/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    
    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <link rel="stylesheet" href="../../jscss/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <script type="text/javascript" src="../../jscss/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="../../jscss/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    
    <link rel="stylesheet" href="../../jscss/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    <script type="text/javascript" src="../../jscss/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
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
          chart: {
            title: 'Lesson Status',
          }
        };
      
        var chart = new google.visualization.PieChart(document.getElementById('columnchart_values'));
        function selectHandler() 
        {
          
          var selectedItem = chart.getSelection()[0];

          if (selectedItem) 
        {
          var topping = data.getValue(selectedItem.row, 0);
          $.ajax ({
                url: "../adminHome.php",
                 success: function(data) {
                  
                $.fancybox.open([
                  {
                    
                    href : 'passingrate.php?lname='+topping, 
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

         google.visualization.events.addListener(chart, 'select', selectHandler);
   
        chart.draw(data, options);

        var cchart = new google.charts.Bar(document.getElementById('columnchart_status'));

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
      google.load('visualization', '1.1', {
        packages: ['bar'],
        callback: numberLessonstatus
      });*/
      /*google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
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
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          }
        };

        var cchart = new google.charts.Bar(document.getElementById('columnchart_status'));

        cchart.draw(cdata, coptions);
      }*/

  </script>
  <body>
    <?php
      $tmp = array_filter($lview);
      if (!empty($tmp))
      {
    ?>
	       <div id="columnchart_values" style="width: 900px; height: 500px;" align="center"></div>
          <hr>
        <div id="columnchart_status" style="width: 700px; height: 400px;" align="center"></div>
    <?php
      }
      else
      {
        echo "No Data Available";
      }
    
    ?>
</body>
</html>