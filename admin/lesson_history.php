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
    
    $l_id   = intval($_GET['lid']);
    $year   = "";
    $month  = "";

    if($year==""){
      date_default_timezone_set("Asia/Kuching");
      $year = date("Y", time());
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
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
    <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
    <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
    <!-- jquery UI -->
    <!-- Added on: 11-04-15 -->
    <script src="../jqueryui/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script src="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.css">
    
</head>
<body>
  <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="viewlesson.php">Lessons</a></li>
    <li class="active">Lesson History</li>
    </ol>
    &nbsp;
<center><b>Lesson Revision History</b></center>
<hr>
&nbsp;
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
    <!-- <form>
        <fieldset>
              <legend>Browse History</legend>
              <label for="year">From year:</label>
              <input id="year" type="number" value="<?php echo $year ?>"/>
              <label for="month">From Month (and earlier):</label>
              <select id="month" class="month_selector">
                <option value="-1" >all</option>
                <option value="1" >January</option>
                <option value="2" >February</option>
                <option value="3" >March</option>
                <option value="4" >April</option>
                <option value="5" >May</option>
                <option value="6" >June</option>
                <option value="7" >July</option>
                <option value="8" >August</option>
                <option value="9" >September</option>
                <option value="10" >October</option>
                <option value="11" >November</option>
                <option value="12" >December</option>
              </select>
              <label for="lesson">Lesson Name:</label>
              <input id="lesson" type="text" value=""/>
              <input type="submit" value="Go">
        </fieldset>
    </form> -->
    <table id="lesson_hist" class="table table-striped table-bordered" cellspacing="0">
      <thead>
        <th align="left">Date/Time Modified</th>
        <th align="left">Lesson Name</th>
        <th align="left">User</th>
        <th align="left">Action</th>
      </thead>

      <?php
      $query_select = "SELECT * FROM lesson_history WHERE lessonid='$l_id' ORDER BY latest_revision_time DESC";
      $result_select = mysql_query($query_select, $link);
      while($row = mysql_fetch_object($result_select)){

      
      ?>
        <tr>
          <td>
            <?php
            echo $row->latest_revision_time; 
            ?>
          </td>
          <td><?php echo $row->lessonname; ?></td>
          <td><?php echo $row->latest_user; ?></td>
          <td id="hist-action">
            <a class="action-tooltip" href="lesson_oldinfo.php?l_hid=<?php echo $row->lesson_hist_id ?>" title="View Lesson Version">
              <img src="../img/viewicon_blue.png">
              <!-- View -->
            </a>
            <a class="action-tooltip" href="revert_lesson.php?l_hid=<?php echo $row->lesson_hist_id ?>" title="Revert Lesson">
              <img src="../img/reverticon_blue.png">
              <!-- Revert -->
            </a>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
    <br><br>
    <a href="viewlesson.php" class = " btn btn-default">Return</a>
<script>
var tool = $.noConflict(true);
$(document).ready(function(){
  function filterGlobal () {
      $('#lesson_hist').DataTable().search(
          $('#global_filter').val(),
          $('#global_regex').prop('checked'),
          $('#global_smart').prop('checked')
      ).draw();
  }
   
  function filterColumn ( i ) {
      $('#lesson_hist').DataTable().column( i ).search(
          $('#col'+i+'_filter').val(),
          $('#col'+i+'_regex').prop('checked'),
          $('#col'+i+'_smart').prop('checked')
      ).draw();
  }


  $('#lesson_hist').DataTable(
      { 
        "fnDrawCallback": function()
            {
                tool(function()
                {
                  tool( ".action-tooltip" ).tooltip(
                  {
                    show: {
                      effect: false
                    },
                    position: {
                        my: "center top-25",
                        at: "center top-20"
                    },
                    show: false,
                    hide: 
                        false
                    
                  });
                });
            },
        "ordering":false,
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