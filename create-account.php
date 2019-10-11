<?php

include('classes/DB.php');


    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

      if(empty($username) && empty($password) && empty($email)){
            echo "All fields are required";
            exit();
      }
      else{
            if(empty($username)){
                  echo "Please enter a username";
                  exit();
            }
            else if(empty($password)){
                  echo "Please enter a password";
                  exit();
            }
            else if(empty($email)){
                  echo "Please enter a email";
                  exit();
            }
            else{
                  echo "";
            }
      }
      if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))){

            if (strlen($username) >=5 && strlen($username) <=32) {

                  if (preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5-31}$/', $username)) {

                        if (strlen($password) >=6 && strlen($password) <=60){

                              if (filter_var($email,FILTER_VALIDATE_EMAIL)) {

                                    if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

                                          DB::query('INSERT INTO users VALUES(\'\',:username,:password,:email)', array(':username'=>$username,':password'=>password_hash($password,PASSWORD_BCRYPT),':email'=>$email));
                                          echo 'Registeration Sucessful.';
                                    }
                                    else{
                                          echo 'User Already Registered.<br>';
                                    }

                              }
                              else{
                                    echo "Invalid email.<br>";
                              }
                        }
                        else {
                              echo "Password must be greater than 6 and less than 60.<br>";
                        }
                  }

                  else{
                        echo "Invalid username.";
                  }
            }
            else {
                  echo "Username must be greater than 5 and less than 32.<br>";
            }


      }
      else{
            echo "Username taken.<br>";
         }


?>
