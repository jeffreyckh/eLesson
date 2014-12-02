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
        <a class="navbar-brand" href="adminHome.php">eLesson</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbarCollapse">
      
      <ul class="nav navbar-nav">
        <li <?=echoActiveClassIfRequestMatches("adminHome")?>><a href="adminHome.php">Home</a></li>
        <li <?=echoActiveClassIfRequestMatches("courses")?>><a href="courses.php">Course</a></li>
        <li <?=echoActiveClassIfRequestMatches("viewlesson")?>><a href="viewlesson.php">Lesson</a></li>
        <li <?=echoActiveClassIfRequestMatches("viewquiz")?>><a href="viewquiz.php">Quiz</a></li>
        <li <?=echoActiveClassIfRequestMatches("view_questionlist")?>><a href="view_questionlist.php">Question</a></li>       
        <li <?=echoActiveClassIfRequestMatches("announcement")?>><a href="announcement.php">Announcement</a></li>
        <li <?=echoActiveClassIfRequestMatches("manageAccount")?>><a href="manageAccount.php">Account</a></li>
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

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}

?>
</html>