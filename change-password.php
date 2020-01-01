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
    <link rel="stylesheet" href="#" />
    <style>
        @import url("https://fonts.googleapis.com/css?family=Montserrat&display=swap");
        @import url("https://fonts.googleapis.com/css?family=Caveat&display=swap");
        @import url('https://fonts.googleapis.com/css?family=Nunito+Sans&display=swap');

        * {
            padding: 0;
            margin: 0;
        }

        body {
            font-family: "Montserrat", sans-serif;
            background-color: #f6f5f7;
            height: 100vh;
        }

        .header {
            display: flex;
            height: 50px;
            justify-content: space-between;
            padding-top: 10px;
        }

        .logo {
            width: 140px;
            text-align: center;
        }

        #friesta {
            color: #ff4b2b;
            font-family: 'Caveat', cursive;
            font-weight: bold;
            font-size: 42px;
            margin: 0 auto;
        }

        a {
            text-decoration: none;
            color: #ff416c;
        }

        a:hover {
            color: #2c3e50;
        }

        #user-link {
            text-decoration: none;
            color: #485460;
        }

        #user-link:hover {
            color: #2c3e50;
        }



        #search {
            border-radius: 2px;
            border: 1px solid #ff416c;
            background: #ff416c;
            color: white;
            font-size: 12px;
            font-weight: bold;
            font-family: "Nunito+Sans", sans-serif;
            padding: 9px 15px;
            letter-spacing: 1px;
            position: relative;
            top: -1px;
            margin-left: -6px;
            transition: transform 80ms ease-in;
        }

        #search:active {
            transform: scale(0.95);
        }

        #search:focus {
            outline: none;
        }

        #search.ghost {
            background: transparent;
            border-color: #fff;
        }

        .search {
            width: 80vh;
            text-align: left;

        }

        .search-input {
            height: 32px;
            width: 80%;
            border: 1px solid #95a5a6;
            border-radius: 2px;
            padding-left: 10px;
            margin-top: 10px;

        }

        .nav-links {
            width: 50%;

        }

        .links {
            text-decoration: none;
            list-style-type: none;
            display: flex;
            justify-content: space-around;
        }

        li {
            padding-top: 20px;
        }

        .change-password {
            text-align: center;
            height: 50vh;
            width: 50%;
            margin: 10% auto;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }

        .current,
        .new,
        .repeat {
            display: flex;
            width: 100%;
            justify-content: center;
            padding: 15px;
        }

        p {
            padding: 5px;
            font-size: 16px;
            position: relative;
            left: -20px;
            color: #2d3436;
        }

        #new_id {
            position: relative;
            left: -31px;
        }



        #new_input {
            position: relative;
            left: 12px;
        }



        button {
            border-radius: 20px;
            border: 1px solid #ff4b2b;
            background: #ff4b2b;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 25px;
            letter-spacing: 1px;
            transition: transform 80ms ease-in;
        }

        button:active {
            transform: scale(0.95);
        }

        button:focus {
            outline: none;
        }

        button.ghost {
            background: transparent;
            border-color: #fff;
        }

        #forgot {
            color: #333;
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
        }

        .box {
            padding: 2px;
        }

        .copyright {
            position: relative;
            top: -40px;
            width: 70%;
            margin: 0 auto;
            display: flex;
            justify-content: flex-end;
        }

        /*Search*/

        .suggestions {
            width: 96.2%;
            border: 1px solid lightslategray;
            border-bottom: none;
            position: relative;
            z-index: 100;
            opacity: 1;
            background: white;
            border-radius: 2px;
            display: none;
        }


        .list {
            padding: 10px;
            font-size: 14px;
            border-bottom: 1px solid lightslategray;
            position: relative;
            left: 0px;

        }

        .list:hover {
            color: #0984e3;
            cursor: pointer;

        }
    </style>
    <script src="./scripts/jquery.min.js"></script>
</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="index.html">
                <h1 id="friesta">Friesta</h1>
            </a>
        </div>
        <div class="search">
            <form action="api/search-user" method='get' id="searchform">
                <input type="text" placeholder="Search" class="search-input sbox">
                <button id="search" type="submit">Search</button>
            </form>
            <div class="suggestions autocomplete">

            </div>

        </div>
        <div class="nav-links">
            <ul class="links">
                <li><a href="index.html">Home</a></li>
                <li><a href="messages.html">Chats</a></li>
                <li><a href="notification.html">Notifications</a></li>
                <li><a id="p" href="">My Profile</a></li>
            </ul>
        </div>
    </div>

    <form action="<?php if (!$tokenIsValid) {
                        echo 'change-password.php';
                    } else {
                        echo 'change-password.php?token=' . $token . '';
                    } ?>" method="post">
        <div class="change-password">
            <p id="error_message" style="color:red;"><?php echo $result; ?></p>

            <div class='current'>
                <?php if (!$tokenIsValid) {
                    echo "<p>Current Password</p>
                <input type='password' class='input box' placeholder='Current Password....' name='oldpassword' id='currentpass'>";
                }
                ?>

            </div>

            <div class="new">
                <p id="new_id">New Password</p>
                <input id="new_input" class='input box' type="password" placeholder="New Password...." name="newpassword" id="newpass">
            </div>
            <div class="repeat">
                <p>Repeat Password</p>
                <input type="password" class="box" placeholder="Repeat Password...." name="newpasswordrepeat" id="newrepeat">
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
    <a href="#" id="forgot">Forgot Password?</a>
    </div>
    <div class="copyright">
        <b><span> &copy; Friesta 2019</span></b>
    </div>
</body>
<script>
$.ajax({
            type: "GET",
                url: "api/check-loggedin",
                processData: false,
                contentType: "application/json",
                data: '',
                success: function (r) {
                    if(r == 'Not logged in'){
                        window.location.href = 'signup-signin.html'
                    }
                }
        })
    $.ajax({
        type: "GET",
        url: "api/users",
        processData: false,
        contentType: "application/json",
        data: '',
        success: function(u) {
            $('#p').attr("href", "profile.php?username=" + u + "")
        }
    })
    $('.sbox').focus(function() {
        $('.autocomplete').html("")
        $('.suggestions').css("display", "block")
    })
    $('body').click(function() {
        $('.autocomplete').html("")
    })

    $('.sbox').keyup(function() {
        $('.autocomplete').html("")
        $.ajax({
            type: "GET",
            url: "api/search?query=" + $(this).val(),
            processData: false,
            contentType: "application/json",
            data: '',
            success: function(r) {
                r = JSON.parse(r)
                for (var i = 0; i < r.length; i++) {
                    $('.autocomplete').html(
                        $('.autocomplete').html() +
                        '<a style="color:black;" href="profile.php?username=' + r[i].username + '#' + r[i].id + '"><p class="list">' + r[i].body + ' ~ <b>' + r[i].username + '</b></p></a>'

                    )
                }
            },
            error: function(r) {
                console.log(r)
            }
        })
    })

    $('#searchform').submit(function(e) {
        e.preventDefault()
        $('.autocomplete').html("")
        $.ajax({
            type: "GET",
            url: "api/search-user?query=" + $('.sbox').val(),
            processData: false,
            contentType: "application/json",
            data: '',
            success: function(r) {
                r = JSON.parse(r)
                for (var i = 0; i < r.length; i++) {
                    $('.autocomplete').html(
                        $('.autocomplete').html() +
                        '<a style="color:black;" href="profile.php?username=' + r[i].username + '"><p class="list">' + r[i].username + '</b></p></a>'
                    )
                }

            },
            error: function(r) {
                console.log(r)
            }
        })
    })
</script>

</html>