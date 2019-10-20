<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Friesta</title>
    <link rel="stylesheet" href="pages/styles/login-style.css">
    <script src="https://kit.fontawesome.com/1032187501.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="scripts/validator.js"></script>

</head>

<body>
    <header>
        <h2>Friesta</h2>
    </header>
    <div class="container" id="container">
        <!-- Sign Up form code goes here -->
        <div class="form-container sign-up-container">
            <form id="signup" action="create-account.php" method="post">
                <p id="error_message" style="color:red;"></p>
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" id="username" placeholder="Name" name="username" />
                <input type="email" id="email" placeholder="Email" name="email" />
                <input type="password" id="password" placeholder="Password" name="password" />
                <button type="submit" name="create-account">Sign Up</button>
            </form>
        </div>
        <!-- Sign In form code goes here -->
        <div class="form-container sign-in-container">
            <form id="signin" action="login.php" method="post">
                <p id="login_error" style="color:red;"></p>
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>
                <input type="text" id="login_username" name="username" placeholder="Username" />
                <input type="password" id="login_password" name="password" placeholder="Password" />
                <a href="#">Forgot your password?</a>
                <button type="submit" id="login" name="login-account">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <!-- The overlay code goes here -->
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>
                        To keep connected with us please login with your personal info
                    </p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="summary">
            <p>Welcome to <b><i>Friesta</i></b> a new social platfrom where you can connect with oter people globally.
                <b><i>Friesta</i></b> provides a secure system where you can discover posts, watch videos, view photos, make posts.
                <b><i>Friesta</i></b> provides facility of secure chating. Working on <b><i>Friesta</i></b> is extremely
                easy to use because of it's wonderful user interface.
            </p>
        </div>
        <br />
        <br />
        <div class="footer">
            <div class="description">
                <a href="pages/about.html" class="desc">About Us</a>
                <a href="pages/terms.html" class="desc">Terms and Policy</a>
                <a href="pages/privacy.html" class="desc">Privacy</a>
                <a href="pages/cookie.html" class="desc">Cookie</a>
            </div>
            <br />
            <div class="developer">
                <div class="developby">
                    <span><b>Developed By ~ Ashish Jaiswar</b></span>
                </div>
                <div class="copyright">
                    <span><b>&copy; Friesta 2019</b> </span>
                </div>

            </div>
        </div>
    </footer>
    <script src="scripts/login-animation.js"></script>
</body>

</html>