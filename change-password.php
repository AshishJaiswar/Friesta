<?php
include('./classes/DB.php');
include('./classes/Login.php');


$result = '';
$tokenIsValid = False;

if (Login::isLoggedIn()) {

    if (isset($_POST['changepassword'])) {

        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];
        $newpasswordrepeat = $_POST['newpasswordrepeat'];
        $userid = Login::isLoggedIn();

        if (password_verify($oldpassword, DB::query('SELECT password FROM users WHERE id=:userid', array(':userid' => $userid))[0]['password'])) {
            if ($newpassword == $newpasswordrepeat) {
                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
                    DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword' => password_hash($newpassword, PASSWORD_BCRYPT), ':userid' => $userid));
                    echo "<script type='text/javascript'>alert('Password changed sucessfully!');</script>";
                    echo "<script type='text/javascript'>window.location='signup-signin.php';</script>";
                }
            } else {
                $result =  'Passwords don\'t match!';
            }
        } else {
            $result = 'Incorrect old password!';
        }
    }
} else {
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if (DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token' => sha1($token)))) {
            $userid = DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token' => sha1($token)))[0]['user_id'];
            $tokenIsValid = True;
            if (isset($_POST['changepassword'])) {
                $newpassword = $_POST['newpassword'];
                $newpasswordrepeat = $_POST['newpasswordrepeat'];
                if ($newpassword == $newpasswordrepeat) {
                    if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
                        DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword' => password_hash($newpassword, PASSWORD_BCRYPT), ':userid' => $userid));
                        echo 'Password changed successfully!';
                        DB::query('DELETE FROM password_tokens WHERE user_id=:userid', array(':userid' => $userid));
                    }
                } else {
                    echo 'Passwords don\'t match!';
                }
            }
        } else {
            die('Token invalid');
        }
    } else {
        die('Not logged in');
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Friesta | change password</title>
    <link rel="stylesheet" href="pages/styles/change-password.css" />
</head>

<body>
    <header>

    </header>
    <form action="<?php if (!$tokenIsValid) {
                        echo 'change-password.php';
                    } else {
                        echo 'change-password.php?token=' . $token . '';
                    } ?>" method="post">
        <div class="change-password">
            <p id="error_message" style="color:red;"><?php echo $result; ?></p>

            <div class='current'>
                <?php if (!$tokenIsValid) {
                    echo "<h5>Current Password</h5>
                <input type='password' class='input' placeholder='Current Password....' name='oldpassword' id='currentpass'>";
                }
                ?>

            </div>

            <div class="new">
                <h5 id="new_id">New Password</h5>
                <input id="new_input" class='input' type="password" placeholder="New Password...." name="newpassword" id="newpass">
            </div>
            <div class="repeat">
                <h5>Repeat Password</h5>
                <input type="password" placeholder="Repeat Password...." name="newpasswordrepeat" id="newrepeat">
            </div>
            <br />
            <div class="submit">
                <button type="submit" name="changepassword" id="submit">
                    Change Password
                </button>
            </div>
    </form>
    <br />
    <br />
    <a href="#">Forgot Password?</a>
    </div>
    <div class="copyright">
        <b><span> &copy; Friesta 2019</span></b>
    </div>
</body>

</html>