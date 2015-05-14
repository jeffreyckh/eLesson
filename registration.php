<?php
session_start(); 
include 'inc/header.php'; 
require_once('inc/db_config.php');
require_once('view/RegistrationView.php');

$register = new RegistrationView();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <!-- 1140px Grid styles for IE -->
        <!--[if lte IE 9]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" /><![endif]-->
    
        <!-- The 1140px Grid - http://cssgrid.net/ -->
        <link rel="stylesheet" href="css/1140.css" type="text/css" media="screen" />
        
        <!-- Your styles -->
        <link rel="stylesheet" href="jscss/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jscss/dist/css/bootstrap.min.css">
        
        <!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
        <script type="text/javascript" src="js/css3-mediaqueries.js"></script>
        <title>Register | eLesson </title>
    </head>
    <body>
        <ol class="breadcrumb">
        <li><a href="login.php">Login</a></li>
        <li class="active">Registration</li>
        </ol>
        <center>
        <div class="container">
            <div class="row">
                <div class="sixcol">
                    <form action="registration.php" method="POST">
                        <fieldset class="fieldset">
                            <legend>Registration Form</legend>
                            <?php
                            $register->validateRegistrationData();
                            ?>

                            <div class="row registration">
                                <div class="fourcol">
                                    <label for="username">  Username           
                                    </label>
                                </div>
                                <div class="fourcol last">
                                    <input type="text" name="username" id="username" placeholder="only 4 to 12 characters" maxlength="15"/>
                                </div>
                            </div>
                            <div class="row registration">
                                <div class="fourcol">
                                    <label for="name">Name
                                    </label>
                                </div>
                                <div class="fourcol last">
                                    <input type="text" name="name" id="name" placeholder="Full Name"maxlength="35"/>
                                </div>
                            </div>
                            <div class="row registration">
                                <div class="fourcol">
                                    <label for="email">Email
                                    </label>
                                </div>
                                <div class="fourcol last">
                                    <input type="text" name="email" id="email" placeholder="example@email.com" maxlength="35"/>
                                </div>
                            </div>
                            <div class="row registration">
                                <div class="fourcol">
                                    <label for="position">Position
                                    </label>
                                </div>
                                <div class="fourcol last">
                                    <input type="text" name="position" id="position"  placeholder="eg. Manager" maxlength="35"/>
                                </div>
                            </div>
                            <div class="row registration">
                                <div class="fourcol">
                                    <label for="password">Password
                                    </label>
                                </div>
                                <div class="fourcol last">
                                    <input type="password" name="password" id="password"  placeholder="Mininum 6 characters" maxlength="35"/>
                                </div> 
                            </div>
                            <div class="row registration">
                                <div class="fourcol">
                                    <label for="RepeatPassword">Re-enter Password
                                    </label>
                                </div>
                                <div class="fourcol last">
                                    <input  type="password" name="RepeatPassword" id="RepeatPassword"  placeholder="Re-enter Password" maxlength="35"/>
                                </div>
                            </div>
                           
                            </div>
                            <div class="row centerObjects">
                                <br>
                                <input class = "btn btn-default" type="submit" name="submit" value="Register" />&nbsp&nbsp
                                <input type="reset" name="Clear" value="Clear" class = "btn btn-default" />
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
                  
            <?php include('inc/footer.php');?>
        </center>
    </body>

</html>


