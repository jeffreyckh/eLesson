<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Home</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
   <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
</head>
<body>
<div class = "col-md-6">
		<!-- begin left nav -->
		<div class="col-sm-2">
			<div class="left-nav">
				<div class="accordion" id="accordion2">
				  <!-- group start -->
				  <div class="panel">
					<div class="accordion-heading">
					  <a class="accordion-toggle leftnav-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
						Complete lesson
					  </a>
					</div>
					<div id="collapseOne" class="accordion-body collapse"> <!-- add "in" to class to load acc section open -->
					  <div class="accordion-inner">
						<table id = "incomplete" width = "100%" class="table table-striped table-bordered" cellspacing="0">
          <p><b>Incomplete Lesson</b></p>
        <thead>
            <th width = "30%" align="right">Course</th>
            <th align="right">Lesson</th>
        </thead>
        <?php
          $incompquery = "SELECT * FROM lessoncomplete WHERE userid = '$uid'AND complete = '0'";
          $incompresult = mysql_query($incompquery);
          echo "<tbody>";
          while($incomp_rows = mysql_fetch_object($incompresult))
          {
            $lessonid = $incomp_rows->lessonid;
            $inlesson = "SELECT *FROM lesson where lessonid = '$lessonid'";
            $lessonresult = mysql_query($inlesson) or die(mysql_error());
            while ($l_rows=mysql_fetch_object($lessonresult))
            {
              $lessonname = $l_rows->lessonname;
              $courseid = $l_rows->direction_id;
              $incourse = "SELECT * FROM course WHERE courseid = '$courseid'";
              $courseresult = mysql_query($incourse) or die(mysql_error());
              while ($c_rows = mysql_fetch_object($courseresult)) 
              {
                $coursename = $c_rows->coursename;
                ?>
                 <tr>
                    <td width = "30%" align="left"><?php echo $coursename ?></a></td>
                    <td align="left"><?php echo "
                       <a href=\"lessons_info.php?lid=$lessonid\">".$lessonname."</a>"; ?></a></td>
                </tr>
          <?php
              }
            }
          }
        ?>
      </tbody>
    </table>
					  </div>
					</div>
				  </div> <!-- end group -->
				  <!-- group start -->
				  <div class="panel">
					<div class="accordion-heading">
					  <a class="accordion-toggle leftnav-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
						Main Link 2
					  </a>
					</div>
					<div id="collapseTwo" class="accordion-body collapse">
					  <div class="accordion-inner">
						<div class="left-nav-section"><a href="product.html" class="leftnav-secondary">Link</a></div>
                         <div class="left-nav-section"><a href="product.html" class="leftnav-secondary">Link</a></div>
					  </div>
					</div>
				  </div> <!-- end group -->
				  <!-- group start -->
				  <div class="panel">
					<div class="accordion-heading">
					  <a class="accordion-toggle leftnav-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
						Main Link 3
					  </a>
					</div>
					<div id="collapseThree" class="accordion-body collapse">
					  <div class="accordion-inner">
						<div class="left-nav-section"><a href="product.html" class="leftnav-secondary">Link</a></div>
                         <div class="left-nav-section"><a href="product.html" class="leftnav-secondary">Link</a></div>
					  </div>
					</div>
				  </div> <!-- end group -->
				  <!-- group start -->
				  <div class="panel">
					<div class="accordion-heading">
					  <a class="accordion-toggle leftnav-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
						Main Link 4
					  </a>
					</div>
					<div id="collapseFour" class="accordion-body collapse">
					  <div class="accordion-inner">
						<div class="left-nav-section"><a href="product.html" class="leftnav-secondary">Link</a></div>
                         <div class="left-nav-section"><a href="product.html" class="leftnav-secondary">Link</a></div>
					  </div>
					</div>
				  </div> <!-- end group -->
				  <!-- group start -->
				  <div class="panel">
					<div class="accordion-heading">
					  <a class="accordion-toggle leftnav-primary" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive">
						Main Link 5
					  </a>
					</div>
					<div id="collapseFive" class="accordion-body collapse">
					  <div class="accordion-inner">
						<div class="left-nav-section"><a href="product.html" class="leftnav-secondary">Link</a></div>
                         <div class="left-nav-section"><a href="product.html" class="leftnav-secondary">Link</a></div>
					  </div>
					</div>
				  </div> <!-- end group -->
				</div>
			</div>
		</div>
		<!-- /left nav -->
</div>
</body>
</html>