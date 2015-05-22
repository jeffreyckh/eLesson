<?php
session_start();
include'../../inc/db_config.php';
	$lessonName = $_GET['lname'];
	echo $lessonName;
	$getlidquery = "SELECT lessonid FROM lesson WHERE lessonname ='".$lessonName."'";
	$getlidresult = mysql_query($getlidquery) or die(mysql_error());
	$lid = mysql_result($getlidresult,0);
	$getquizquery = "SELECT * FROM quiz WHERE lessonid ='".$lid."'";
	$getquizresult = mysql_query($getquizquery) or die(mysql_error());
	while ($l_rows = mysql_fetch_object($getquizresult)) {
		$qname = $l_rows->quizname;
		$qid = $l_rows->quizid;
	}
	$getpassingratequery = "SELECT * FROM passingrate WHERE quizid ='".$qid."'";
	$getpassingrateresult = mysql_query($getpassingratequery);
	$numofquiz = mysql_num_rows($getpassingrateresult);


	$getpassquery = "SELECT * FROM passingrate WHERE pass = '1' AND quizid ='".$qid."'";
	$getpassresult = mysql_query($getpassquery);
	$numofpass = mysql_num_rows($getpassresult);
	
	$numoffail = $numofquiz - $numofpass;
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
  	$.fancybox.close();
    function passingRateChart()
      {
        // pie Chart for passing ate
          var data = google.visualization.arrayToDataTable([
            ['PassFail', 'Number of people'],
            ['Pass',    <?php echo $numofpass?>],
            ['Fail',    <?php echo $numoffail?>]
          ]);
       
          var options = {
          chart: {
            title: 'Passing Rate - <?php echo $qname; ?>',
          }
        };


          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        
          chart.draw(data, options);
        }
        google.load('visualization', '1', {
        packages: ['corechart'],
        callback: passingRateChart
        });
    

  </script>
  <body>

         <div id="piechart" style="width: 900px; height: 600px;" align="center"></div>
    ?>

</body>
</html>