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
    if($urank == 2)
        {
            include '../inc/normalAdminNav.php';
        }
        else
        {
           include 'adminNav.php'; 
        }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Lesson History Log</title>
  <link rel="stylesheet" href="home.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
    <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
</head>
<body>
<h3>Lesson Revision History</h3>
    <table id="table_filter" class="filter" width="800" border="0" cellpadding="30" cellspacing="10">
      <thead>
        <tr>
          <th>Target</th>
          <th>Search text</th>
          <th>Treat as regex</th>
          <th>Use smart search</th>
        </tr>
      </thead>
      <tbody>
        <tr id="filter_global">
            <td>Global search</td>
            <td align="center"><input type="text" class="global_filter" id="global_filter"></td>
            <td align="center"><input type="checkbox" class="global_filter" id="global_regex"></td>
            <td align="center"><input type="checkbox" class="global_filter" id="global_smart"></td>
        </tr>
        <tr id="filter_col1" data-column="0">
            <td>Column - DateTime</td>
            <td align="center"><input type="text" class="column_filter" id="col0_filter"></td>
            <td align="center"><input type="checkbox" class="column_filter" id="col0_regex"></td>
            <td align="center"><input type="checkbox" class="column_filter" id="col0_smart"></td>
        </tr>
      </tbody>

    </table>
    <table id="lesson_hist" class="table table-striped table-bordered" cellspacing="0">
      <thead>
        <th align="left">Latest Activity Time</th>
        <th align="left">Lesson Name</th>
        <th align="left">User</th>
        <th align="left">Action</th>
      </thead>

      <?php
      $query_select = "SELECT * FROM lesson_history ORDER BY latest_revision_time DESC";
      $result_select = mysql_query($query_select, $link);
      while($row = mysql_fetch_object($result_select)){

      
      ?>
        <tr>
          <td><?php echo $row->latest_revision_time; ?></td>
          <td><?php echo $row->lessonname; ?></td>
          <td><?php echo $row->latest_user; ?></td>
          <td>
            <a href="lesson_oldinfo.php?l_hid=<?php echo $row->lesson_hist_id ?>">View</a>
            <a href="revert_lesson.php?l_hid=<?php echo $row->lesson_hist_id ?>">Revert</a>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
<script>
  function filterGlobal () {
      $('#lesson_hist').DataTable().search(
          $('#global_filter').val(),
          $('#global_regex').prop('checked')
      ).draw();
  }

  function filterColumn ( i ) {
    $('#lesson_hist').DataTable().column( i ).search(
        $('#col'+i+'_filter').val(),
        $('#col'+i+'_regex').prop('checked')
    ).draw();
  }

  $(document).ready(function(){
  $('#lesson_hist').DataTable(
      { 
          "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
      });
    $('input.global_filter').on('keyup click', function(){
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function(){
        filterColumn( $(this).parents('tr').attr('data-column') );
    } );
  });

  

  </script>
</body>
</html>