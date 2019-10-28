<<<<<<< HEAD
<?php
include('classes/DB.php');
include('./classes/Mail.php');

if (isset($_POST['resetpassword'])) {
    $cstrong = True;
    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
    $email = $_POST['email'];
    $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email' => $email))[0]['id'];
    DB::query('INSERT INTO password_tokens VALUES (\'\',:token, :user_id)', array(':token' => sha1($token), ':user_id' => $user_id));
    Mail::sendMail('Forgot Password!', "Reset password ~ <br/><a href='http://localhost:8081/Friesta/change-password.php?token=$token'>http://localhost:8081/Friesta/change-password.php?token=$token</a>", $email);
    echo "Email Sent";
}
?>

<h1>Forgot Password</h1>
<form action='forgot-password.php' method="post">
    <input type="email" name="email" placeholder="Enter Email....">
    <p />
    <input type="submit" value="Reset Password" name="resetpassword">


=======
<?php
include('classes/DB.php');
include('./classes/Mail.php');

if (isset($_POST['resetpassword'])) {
    $cstrong = True;
    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
    $email = $_POST['email'];
    $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email' => $email))[0]['id'];
    DB::query('INSERT INTO password_tokens VALUES (\'\',:token, :user_id)', array(':token' => sha1($token), ':user_id' => $user_id));
    Mail::sendMail('Forgot Password!', "Reset password ~ <br/><a href='http://localhost:8081/Friesta/change-password.php?token=$token'>http://localhost:8081/Friesta/change-password.php?token=$token</a>", $email);
    echo "Email Sent";
}
?>

<h1>Forgot Password</h1>
<form action='forgot-password.php' method="post">
    <input type="email" name="email" placeholder="Enter Email....">
    <p />
    <input type="submit" value="Reset Password" name="resetpassword">


>>>>>>> 14226c79fce92bcb97faa12b3af6bbe784836f0b
</form>