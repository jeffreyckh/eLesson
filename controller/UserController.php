<?php
	include "DatabaseController.php";
	class UserController{

		public function register($username,$password,$repeatPassword, $name, $email, $position){
			try {
				/*$username = stripslashes($username);
				$password = stripslashes($password);
				$repeatPassword = stripslashes($repeatPassword);
				$name = stripslashes($name);
				$email = stripslashes($email);
				$position = stripslashes($position);*/
				if ($_SERVER["REQUEST_METHOD"] == "POST") {

					if(empty($username)||empty($password)||empty($repeatPassword)||empty($name)||empty($email)|| empty($position)){
						throw new Exception( "<script type='text/javascript'>alert('All Field is Required!!')</script>");

					}
					if (strlen($username) < 3 || strlen($username) > 13)
					{
						throw new Exception( "<script type='text/javascript'>alert('Username must between 4 to 12 characters')</script>");	
					}

					if(is_numeric($name)){	
					throw new Exception( "<script type='text/javascript'>alert('Name must not be numeric!')</script>");	
					}
					if (strcmp($password, $repeatPassword) != 0) {
	               	throw new Exception(
	               	"<script type='text/javascript'>alert('Password and Re-entered password do not match!')</script>");
	            	}
	            	if (strlen($password) < 4 || strlen($password) > 13) {
	                throw new Exception(
	                  "<script type='text/javascript'>alert('Password must be longer than 6 character!')</script>");
	            	}
	            
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  					throw new Exception(
	                  "<script type='text/javascript'>alert('Invalid email')</script>");; 
					}
				}

            	$rView = new RegistrationView();
            	$result = $rView->registerAccount();

			} catch (Exception $e) {
				throw $e;				
			}
		}

		public function authenticateUser($username,$password){
			$result = FALSE;

			try{
				if (empty($username) && empty($password)){
					throw new Exception("Username and password must not be empty.");	
				} elseif (empty($username) && !empty($password)){
					throw new Exception("Username must not be empty");
				} elseif (!empty($username) && empty($password)){
					throw new Exception("Password must not be empty");	
				}
				$dbController = new DatabaseController();
				$result = $dbController->selectUser($username, $password);

				} catch (ErrorException $e) {
            		throw $e;
        		} catch (mysqli_sql_exception $e) {
            		throw $e;
        		} catch (Exception $e) {
           			throw $e;
        		}
        		
        		return $result;
		}


	}	
	