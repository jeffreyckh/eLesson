<?php
include('inc/db_config.php');
require_once('controller/UserController.php');
require_once ('controller/DatabaseController.php');
class RegistrationView{
  

  function registerAccount(){
    
    if (isset($_POST['username']) && isset($_POST['password'])){
    $db_controller = new DatabaseController();
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $db_controller->registerUser($username,$password,$position,$email,$name);
    }
  } 

   function validateRegistrationData()
  {
    if (isset($_POST['submit'])){
      try {
        $userController = new userController();
        $userController->register($_POST['username'], $_POST['password'], $_POST['RepeatPassword'], $_POST['name'], $_POST['email'], $_POST['position']);  
        echo'<p class="success_message">Registration is successful.Please wait for admin to approve your application</p>';
      } 
        catch (Exception $e) {
        echo '<p class="error_message">' . $e->getMessage() . '</p>';
        }
      }
    }
  function validateLoginData(){
    if (isset($_POST['Login']) && isset($_POST['Username']) && isset($_POST['Password'])){
      try{
        $username = htmlspecialchars($_POST['Username']);
        $password = MD5($_POST['Password']);

        $userController = new userController();
        $user = $userController->authenticateUser($username,$password);
        
      } catch (ErrorException $e) {
                echo '<p class="error_message">' . $e->getMessage() . '</p>';
            } catch (mysqli_sql_exception $e) {
                echo '<p class="error_message">' . $e->getMessage() . '</p>';
            } catch (Exception $e) {
                echo '<p class="error_message">' . $e->getMessage() . '</p>';
            }
    }

  }
  }

?>
