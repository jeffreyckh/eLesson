
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="Navbar">
  <meta name="description" content="Navbar">
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>

    <!-- jquery UI -->
    <!-- Added on: 11-04-15 -->
    <script src="../jqueryui/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script src="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="../jqueryui/jquery-ui-1.11.4.custom/jquery-ui.css">
    <script type="text/javascript">
    var jquery_1_11_4 = $.noConflict(true);
    jquery_1_11_4(function(){
      jquery_1_11_4( ".nav-tooltip" ).tooltip({
        show: {
          effect: false
        },
        position: {
          my: "center top+18",
          at: "right center"
        }
      });
    });
    </script>
    <style>
    label{
      display: inline-block;
      /*width: 5em;*/
    }
    </style>

</head>

<body>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbarCollapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="userHome.php">
          <img id="home_icon" src="../img/elessonlogo2_600x600.png">
          <!-- eLesson -->
        </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbarCollapse">
      <?php
      $active_state = false;
      ?>
      <ul class="nav navbar-nav">
        <li <?=echoActiveClassIfRequestMatches("userHome")?>>
          <a href="userHome.php">
            <?php
            if($active_state==true){
              echo '<img id="home_icon" src="../img/homeicon_white_600x600.png">';
              $active_state = false;
            }else{
              echo '<img id="home_icon" src="../img/homeicon5_600x600.png">';
            }
            ?>
            <!-- Home -->
          </a>
        </li>
        <li <?=echoActiveClassIfRequestMatches("courses")?>
          <?=echoActiveClassIfRequestMatches("lesson")?>
          >
          <a href="courses.php">
            <?php
            if($active_state==true){
              echo '<img id="home_icon" src="../img/courseicon_white_600x600.png">';
              $active_state = false;
            }else{
              echo '<img id="home_icon" src="../img/courseicon2_600x600.png">';
            }
            ?>
            <!-- Course -->
          </a>
        </li>
        <li <?=echoActiveClassIfRequestMatches("user_viewquiz")?>>
          <a href="user_viewquiz.php">
            <?php
            if($active_state==true){
              echo '<img id="home_icon" src="../img/quizicon_white_600x600.png">';
              $active_state = false;
            }else{
              echo '<img id="home_icon" src="../img/quizicon2_600x600.png">';
            }
            ?>
            <!-- Quiz -->
          </a>
        </li>
         <li <?=echoActiveClassIfRequestMatches("announcement")?>>
          <a href="announcement.php">
            <?php
            if($active_state==true){
              echo '<img id="home_icon" src="../img/announceicon_white_600x600.png">';
              $active_state = false;
            }else{
              echo '<img id="home_icon" src="../img/announceicon2_600x600.png">';
            }
            ?>
            <!-- Announcement -->
          </a>
        </li>
          </ul>
        </li>
      </ul>

        <form method="post" action="../login.php" id="navBar">
        <ul class="nav navbar-nav navbar-right">
        <div class=".col-md-4">
        <p class="navbar-text">Signed in as: <?php echo $_SESSION['username']?></a></p>
        <input class="btn btn-default navbar-btn" type="submit" value="Sign Out" name="submit"/>
        </div>
      </ul>
      </form>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</body>
<?php 
function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ( strpos($current_file_name, $requestUri) !== false){
        echo 'class="active"';
        global $active_state;
        $active_state = true;
      }
}

?>
</html>