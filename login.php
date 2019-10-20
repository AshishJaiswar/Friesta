<?php
include('classes/DB.php');


$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) && empty($password)) {
      echo "All fields are required";
      exit();
} else {
      if (empty($username)) {
            echo "Please enter a username";
            exit();
      } else if (empty($password)) {
            echo "Please enter a password";
            exit();
      } else {
            echo "";
      }
}
if (DB::query('SELECT username FROM users WHERE username=:username', array(':username' => $username))) {

      if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username' => $username))[0]['password'])) {

            $cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
            $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username' => $username))[0]['id'];
            DB::query('INSERT INTO login_tokens VALUES (\'\',:token, :user_id)', array(':token' => sha1($token), ':user_id' => $user_id));
            setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
            setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
            echo "Sucess";
      } else {
            echo "Incorrect Password";
      }
} else {
      echo "User not registered";
}
