<<<<<<< HEAD
<?php

include('classes/DB.php');
include('classes/Login.php');
$showTimeline = False;
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        die('Not logged in');
}

if (isset($_POST['uploadprofileimg'])) {
        Image::uploadImage('profileimg', "UPDATE users SET profileimg = :profileimg WHERE id=:userid", array(':userid' => $userid));
}
?>
<h1>My Account</h1>
<form action="my-account.php" method="post" enctype="multipart/form-data">
        Upload a profile image:
        <input type="file" name="profileimg">
        <input type="submit" name="uploadprofileimg" value="Upload Image">
=======
<?php

include('classes/DB.php');
include('classes/Login.php');
$showTimeline = False;
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        die('Not logged in');
}

if (isset($_POST['uploadprofileimg'])) {
        Image::uploadImage('profileimg', "UPDATE users SET profileimg = :profileimg WHERE id=:userid", array(':userid' => $userid));
}
?>
<h1>My Account</h1>
<form action="my-account.php" method="post" enctype="multipart/form-data">
        Upload a profile image:
        <input type="file" name="profileimg">
        <input type="submit" name="uploadprofileimg" value="Upload Image">
>>>>>>> 14226c79fce92bcb97faa12b3af6bbe784836f0b
</form>