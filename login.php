<?php
include('classes/DB.php');

if(isset($_POST['login'])){
      $username = $_POST['username'];
      $password = $_POST['password'];

      if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

            if(password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])){
                  echo "Loged in";
                  $cstrong = True;
                  $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                  $user_id = DB::query('SELECT id FROM users WHERE username=:username',array(':username'=>$username))[0]['id'];
                  DB::query('INSERT INTO login_tokens VALUES (\'\',:token, :user_id)', array(':token'=>sha1($token),':user_id'=>$user_id));
                  setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                  setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
            }
            else{
                  echo "Incorrect Password";
            }
      }
      else{
            echo "User not registered";
      }

}

?>
<h1>Login User</h1>
<form  action="login.php" method='post'>
      <input type="text" placeholder="Username/Email" name="username"><p/>
      <input type="password" placeholder="Password" name="password"><p/>
      <input type="submit" name="login" value="Login"><p/>
</form>
