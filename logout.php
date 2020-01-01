<?php
include('classes/DB.php');
include('classes/Login.php');

if (!Login::isLoggedIn()) {
      die('Not Logged in!');
}

if (isset($_POST['confirm'])) {

      if (isset($_POST['alldevices'])) {
            DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid' => Login::isLoggedIn()));
      } else {
            if (isset($_COOKIE['SNID'])) {
                  DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token' => sha1($_COOKIE['SNID'])));
            }
            setcookie('SNID', '1', time() - 3600);
            setcookie('SNID_', '1', time() - 3600);
      }
      header("Location: http://localhost:8081/socialnetwork/index.html");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <script src="./scripts/jquery.min.js"></script>
      <title>Friesta | Logout</title>

      <style>
            @import url("https://fonts.googleapis.com/css?family=Montserrat&display=swap");
            @import url('https://fonts.googleapis.com/css?family=Caveat&display=swap');

            .container {
                  background: #fff;
                  border-radius: 10px;
                  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
                  position: relative;
                  overflow: hidden;
                  width: 768px;
                  max-width: 100%;
                  min-height: 200px;
                  margin: 100px auto;
            }

            h1 {
                  font-family: "Montserrat", sans-serif;
                  padding-left: 5px;
            }


            .confirm {
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

            .confirm-box {
                  width: 50%;
                  margin: 0 auto;
                  text-align: center;
                  position: relative;
                  top: 20px;
                  display: flex;
                  justify-content: space-around;
            }

            [type="checkbox"]:not(:checked),
            [type="checkbox"]:checked {
                  position: absolute;
                  left: -9999px;
            }

            [type="checkbox"]:not(:checked)+label,
            [type="checkbox"]:checked+label {
                  position: relative;
                  padding-left: 1.95em;
                  padding-top: 3px;
                  cursor: pointer;
            }

            [type="checkbox"]:not(:checked)+label:before,
            [type="checkbox"]:checked+label:before {
                  content: '';
                  position: absolute;
                  left: 0;
                  top: 0;
                  width: 1.25em;
                  height: 1.25em;
                  border: 2px solid #ccc;
                  background: #fff;
                  border-radius: 4px;
                  box-shadow: inset 0 1px 3px rgba(0, 0, 0, .1);
            }

            [type="checkbox"]:not(:checked)+label:after,
            [type="checkbox"]:checked+label:after {
                  content: '\2713\0020';
                  position: absolute;
                  top: .15em;
                  left: .22em;
                  font-size: 1.3em;
                  line-height: 0.8;
                  color: #09ad7e;
                  transition: all .2s;
                  font-family: 'Lucida Sans Unicode', 'Arial Unicode MS', Arial;
            }

            /* checked mark aspect changes */
            [type="checkbox"]:not(:checked)+label:after {
                  opacity: 0;
                  transform: scale(0);
            }

            [type="checkbox"]:checked+label:after {
                  opacity: 1;
                  transform: scale(1);
            }

            label {
                  font-size: 16px;
                  font-family: "Montserrat", sans-serif;
            }

            .check {
                  padding-left: 5px;
            }
      </style>
</head>

<body>
      <div class="container">
            <h1>Logout of your account?</h1>
            <form action="logout.php" method='post'>
                  <div class="check">
                        <input id="test1" type="checkbox" name="alldevices" value=""><label for="test1">Logout from all devices?</label>
                  </div>

                  <div class="confirm-box">
                        <input id="cancel" class="confirm" type="submit" value="Cancel">
                        <input class="confirm" type="submit" value="Confirm" name="confirm">
                  </div>
            </form>
      </div>
</body>
<script>
      $('#cancel').click(function(e) {
            e.preventDefault();
            window.location.href = "index.html"
      })
</script>

</html>