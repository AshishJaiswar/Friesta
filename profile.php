<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Image.php');
include('./classes/Notify.php');
if (Login::isLoggedIn()) {

        $userid = Login::isLoggedIn();
} else {
        echo 'Not logged in';
}
$username = "";
$verified = False;
$isFollowing = False;
if (isset($_GET['username'])) {
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username' => $_GET['username']))) {
                $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username' => $_GET['username']))[0]['username'];
                $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username' => $_GET['username']))[0]['id'];
                $verified =  DB::query('SELECT verified FROM users WHERE username=:username', array(':username' => $_GET['username']))[0]['verified'];
                //profile
                $name = DB::query('SELECT fullname FROM  profiles WHERE username =:username', array(':username' => $_GET['username']));
                $profileimg = DB::query('SELECT profileimg FROM  users WHERE username =:username', array(':username' => $_GET['username']));
                $lives_in = DB::query('SELECT lives_in FROM  profiles WHERE username =:username', array(':username' => $_GET['username']));
                $relationship = DB::query('SELECT relationship FROM  profiles WHERE username =:username', array(':username' => $_GET['username']));
                $joined_by = DB::query('SELECT joined_by FROM  profiles where username =:username', array(':username' => $_GET['username']))[0]['joined_by'];
                $d = new DateTime($joined_by);
                $joined_by = $d->format('d-M-Y\ ');
                $bio =  DB::query('SELECT bio FROM  profiles WHERE username =:username', array(':username' => $_GET['username']));
                $total_posts = DB::query('SELECT count(posts.id) FROM posts , users WHERE users.username=:username AND users.id =posts.user_id', array(':username' => $_GET['username']))[0]['count(posts.id)'];
                $total_follower = DB::query('SELECT count(*) FROM followers , users WHERE users.username=:username AND users.id =followers.user_id', array(':username' => $_GET['username']))[0]['count(*)'];
                $total_following = DB::query('SELECT count(*) FROM followers , users WHERE users.username=:username AND users.id =followers.follower_id', array(':username' => $_GET['username']))[0]['count(*)'];
                //profile
                $followerid = Login::isLoggedIn();
                if (isset($_POST['follow'])) {
                        if ($userid != $followerid) {
                                if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':followerid' => $followerid))) {
                                        DB::query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid' => $userid, ':followerid' => $followerid));
                                        if ($followerid == 18) {
                                                DB::query('UPDATE users SET verified=1 WHERE id=:userid', array(':userid' => $userid));
                                        }
                                } else {
                                        echo 'Already following!';
                                }
                                $isFollowing = True;
                        }
                }
                if (isset($_POST['unfollow'])) {
                        if ($userid != $followerid) {
                                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':followerid' => $followerid))) {
                                        if ($userid == 18) {
                                                DB::query('UPDATE users SET verified=0 WHERE id=:userid', array(':userid' => $userid));
                                        }
                                        DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':followerid' => $followerid));
                                }
                                $isFollowing = False;
                        }
                }
                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid' => $userid, ':followerid' => $followerid))) {
                        //echo 'Already following!';
                        $isFollowing = True;
                }

                if (isset($_POST['deletepost'])) {
                        if (DB::query('SELECT id FROM posts WHERE id=:postid AND user_id=:userid', array(':postid' => $_GET['postid'], ':userid' => $followerid))) {
                                DB::query('DELETE FROM posts WHERE id=:postid AND user_id=:userid', array(':postid' => $_GET['postid'], ':userid' => $followerid));
                                DB::query('DELETE FROM post_likes WHERE id=:postid', array(':postid' => $_GET['postid']));
                                echo "post deleted";
                        }
                }
                if (isset($_POST["post"])) {

                        if ($_FILES['postimg']['size'] == 0) {
                                Post::createPost($_POST['postbody'], Login::isLoggedIn(), $userid);
                        } else {
                                $postid = Post::createImgPost($_POST['postbody'], Login::isLoggedIn(), $userid);
                                Image::uploadImage('postimg', "UPDATE posts SET postimg=:postimg WHERE id=:postid", array(':postid' => $postid));
                        }
                }

                if (isset($_GET['postid']) && !isset($_POST['deletepost'])) {
                        Post::likePost($_GET['postid'], $followerid);
                }

                $posts = Post::displayPosts($userid, $username, $followerid);
        } else {
                die('User not found!');
        }
}
?>
<!--
<h1><?php echo $username; ?>'s Profile<?php if ($verified) {
                                                echo "~ Verified";
                                        } ?></h1>
<form action="profile.php?username=<?php echo $username; ?>" method="post">
        <?php
        if ($userid != $followerid) {
                if ($isFollowing) {
                        echo '<input type="submit" name="unfollow" value="Unfollow">';
                } else {
                        echo '<input type="submit" name="follow" value="Follow">';
                }
        }
        ?>
</form>

<form action="profile.php?username=<?php echo $username; ?>" method="post" enctype="multipart/form-data">
        <textarea name="postbody" rows="8" cols="80"></textarea>
        <br />Upload an image:
        <input type="file" name="postimg">
        <input type="submit" name="post" value="Post">
</form>

<div class="posts">
        <?php echo $posts ?>

</div>
-->

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Firesta | Profile</title>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="./pages/styles/modal.css">
        <script src="./scripts/jquery.min.js"></script>
        <link rel="stylesheet" href="pages/styles/profile.css">
        <style>
        .suggestions {
  width: 96.2%;
  border: 1px solid lightslategray;
  border-bottom: none;
  position: relative;
  z-index: 100;
  opacity: 1;
  background: white;
  border-radius: 2px;
  display:none;
}


.list {
  padding: 10px;
  font-size: 14px;
  border-bottom: 1px solid lightslategray;

}

.list:hover {
  color: #0984e3;
  cursor: pointer;

}

        </style>
</head>

<body>
        <div class="header">
                <div class="logo">
                        <a href="#">
                                <h1 id="friesta">Friesta</h1>
                        </a>
                </div>
                <div class="search">
                        <form action="api/search-user" method='get' id="searchform">
                                <input type="text" placeholder="Search" class="search-input sbox">
                                <button id="user-search" type="submit">Search</button>
                        </form>
                        <div class="suggestions autocomplete">

                        </div>
                </div>
                <div class="nav-links">
                        <ul class="links">
                        <li><a href="index.html">Home</a></li>
                <li><a href="messages.html">Chats</a></li>
                <li><a href="notification.html">Notifications</a></li>
                <li><a  id="p" href="">My Profile</a></li>
                        </ul>
                </div>
        </div>

        <div class="container">
                <div class="profile-image">
                        <div class="profile-div">
                                <div class="circle" style="border:1px solid #979a9a; overflow: hidden;">
                                        <img class="default-image" src="<?php echo $profileimg[0]['profileimg']; ?>">
                                </div>
                        </div>
                        <div class="edit">
                                <button class="edit-btn" onclick="window.location.href='profile-edit.html'">Edit Profile</button>
                        </div>
                </div>
                <div class="info">
                        <div class="user-detail">
                                <div class="name-address">
                                        <h1 class="name"><?php if ($name != null) {
                                                                        echo $name[0]['fullname'];
                                                                } ?><?php if ($verified) {
                                                                                echo "<span><img class='verified' src='pages/images/verified.png'></span>";
                                                                        }  ?></h1>
                                        <p id="u" style="color:#0984e3;font-size:14px;">@<?php echo $username; ?></p>
                                        <p class="location"><span><?php if ($lives_in != null) {
                                                                                echo '<img class="location-icon" src="pages/images/location-gray-512.png">';
                                                                        } ?></span><?php if ($lives_in != null) {
                                                                                                echo $lives_in[0]['lives_in'];
                                                                                        } ?></p>
                                </div>
                                <div class="other-detail">
                                        <p> <?php if ($relationship != null) {
                                                        echo "<b>Relationship ~ </b>";
                                                } ?><span><?php if ($relationship != null) {
                                                                        echo $relationship[0]['relationship'];
                                                                } ?></span> </p>
                                        <p><?php if ($joined_by != null) {
                                                        echo "<b>Joined ~ </b>";
                                                } ?> <span><?php echo $joined_by; ?></span></p>
                                </div>
                                <div class="bio">
                                        <p style="text-align: justify;"> <?php if ($bio != null) {
                                                                                        echo '<b>Bio ~ </b>' . $bio[0]['bio'];
                                                                                } ?></span></p>
                                </div>

                        </div>
                </div>
                <div class="followarea">
                        <div class="follow-message">
                                <div class="follow">
                                        <form action="profile.php?username=<?php echo $username; ?>" method="post" id="followform">
                                                <?php
                                                if ($userid != $followerid) {
                                                        if ($isFollowing) {
                                                                echo '<button class="unfollow-user" name="unfollow">Unfollow</button>';
                                                        } else {
                                                                echo '<button class="follow-user" name="follow">Follow</button>';
                                                        }
                                                }
                                                ?>
                                        </form>


                                </div>
                                <div class="message">
                                        <a href="messages.html"> <button class="message-user">Message</button></a>
                                </div>
                        </div>
                        <div class="count">
                                <div class="total-post">
                                        <p>posts</p>
                                        <p><?php echo $total_posts; ?></p>
                                </div>
                                <div class="total-follower">
                                        <p>followers</p>
                                        <p><?php echo $total_follower ?></p>
                                </div>
                                <div class="total-following">
                                        <p>following</p>
                                        <p><?php echo $total_following ?></p>
                                </div>
                        </div>
                        <div class="setting">
                                <button class="setting-btn">Setting</button>
                        </div>
                </div>
        </div>
        <div class="timeline-posts">
                <div class="timeline">

                </div>
                <div class="modal fade" role="dialog" tabindex="-1">
                <div class="modal-dialog" role="document" style="border:none;border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="padding-top:10px;">Comments</h4>
                        </div>
                        <div class="modal-content" style="height:300px;">
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                            <p>Hurry become first to comment....</p>
                        </div>
                        </div>
                        <div class="modal-footer" style="top:10px;"> <textarea type="text" name="comment_content" id="comment_content"
                                placeholder="comment" style="width: 73%; position: relative; top: -1px;"></textarea>
                            <button class="postcomment" type="submit" \ name="submit">comment</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-light" type="button"
                                data-dismiss="modal"
                                onclick="$('.modal-body').html('Hurry become first to comment....')">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

</body>
<script type="text/javascript">
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
        
        function scrollToAnchor(aid) {
                try {
                        var aTag = $(aid);
                        $('html,body').animate({
                                scrollTop: aTag.offset().top
                        }, 'slow');
                } catch (error) {
                        console.log(error)
                }
        }

        $('.setting-btn').click(function() {
                $('.modal').modal('show')
                $('.modal-dialog').css({
                        "width": "25%",
                        "height": "36.5vh"
                })
                $('.modal-dialog').html('<div style="text-align:center;padding:3vh;"><a href="change-password.php" style="color:#2d3436;">Change Password</a></div>\
                <hr>\
                <div style="text-align:center;padding:3vh;"><a  href=# style="color:#2d3436;">Report a problem</a></div>\
                <hr>\
                <div style="text-align:center;padding:3vh;"><a  href="logout.php" style="color:#2d3436;">Logout</a></div>\
                <hr>\
                <div style="text-align:center;padding:3vh;"><p  style="color:#2d3436;cursor:pointer" onclick="modal_hide()">Cancel</p></div>\
                ')
        })
        function modal_hide(){
                $('.modal').modal('hide')
        }
        $(document).ready(function() {
                $.ajax({
                        type: 'GET',
                        url: "api/profileposts?username=<?php echo $username; ?>",
                        processData: false,
                        contentType: 'application/json',
                        data: '',
                        success: function(data) {
                                var posts = JSON.parse(data)
                                $.each(posts, function(index) {
                                        var d = new Date(posts[index].PostDate);

                                        if (posts[index].PostImage == "") {
                                                timeline = '<div class="user-posts" id=' + posts[index].PostId + '><div class="username">\
                        <div class="profile-logo" style="overflow:hidden">\
                        <img src="' + posts[index].ProfileImg + '" style="height:30px;width:30px;">\
                        </div>\
                        <h3 class="user_name"><a id="user-link" href="profile.php?username=' + posts[index].PostedBy + '">' + posts[index].PostedBy + '</a></h3>\
                    </div>\
                    <div class="time">\
                        <span  style="font-size:9px;position:relative;top:10px;right:-5px;margin-top:20px;">' + d.toDateString() + '</span>\
                    </div>\
                    <div class="posted-area">\
                        <p> ' + posts[index].PostBody + '\
                        </p>\
                    </div>\
                    <div class="like-comment">\
                        <div class="like">\
                            <div class="heart" data-id="' + posts[index].PostId + '">\
                                <p class="like-number">' + posts[index].Likes + '</p>\
                            </div>\
                        </div>\
                        <div class="comment"  data-postid="' + posts[index].PostId + '" >\
                            <img class="comment-icon" src="./pages/images/flash.svg">\
                            <span class="comment-btn">comments</span>\
                        </div>\
                    </div>\
                    <div class="display" style="display: none;">\
                      <input class="input-comment" type="text" placeholder="Add Comment"> <span><button>Comment</button></span>\
                      <div class="posted-comment">\
                        <p ><b>_ashish_jaiswar_ ~</b> <span>Nice Post</span></p>\
                      </div>\
                </div>'
                                        } else {
                                                timeline = '<div class="user-posts" id=' + posts[index].PostId + '><div class="username">\
                        <div class="profile-logo" style="overflow:hidden">\
                        <img src="' + posts[index].ProfileImg + '" style="height:30px;width:30px;">\
                        </div>\
                        <h3 class="user_name"><a id="user-link" href="profile.php?username=' + posts[index].PostedBy + '">' + posts[index].PostedBy + '</a></h3>\
                    </div>\
                    <div class="time">\
                        <span  style="font-size:9px;position:relative;top:10px;right:-5px;margin-top:20px;">' + d.toDateString() + '</span>\
                    </div>\
                    <div class="posted-area">\
                        <p> ' + posts[index].PostBody + '\
                        </p>\
                        <img src="" class="postimg" data-tempsrc="' + posts[index].PostImage + '" id="img' + posts[index].PostId + '" style="opacity: 0;transition: all 2s ease-in-out;width: 100%;">\
                    </div>\
                    <div class="like-comment">\
                        <div class="like">\
                            <div class="heart" data-id="' + posts[index].PostId + '">\
                                <p class="like-number">' + posts[index].Likes + '</p>\
                            </div>\
                        </div>\
                        <div class="comment"  data-postid="' + posts[index].PostId + '" >\
                            <img class="comment-icon" src="./pages/images/flash.svg">\
                            <span class="comment-btn">comments</span>\
                        </div>\
                    </div>\
                    <div class="display" style="display: none;">\
                      <input class="input-comment" type="text" placeholder="Add Comment"> <span><button>Comment</button></span>\
                      <div class="posted-comment">\
                        <p ><b>_ashish_jaiswar_ ~</b> <span>Nice Post</span></p>\
                      </div>\
                </div>'
                                        }

                                        $('#p').attr("href", "profile.php?username="+ posts[index].PostedBy+"")

                                        $('.timeline').html(
                                                $('.timeline').html() + timeline
                                        )

                                        $('[data-postid]').click(function() {
                                                $('.modal').modal('show')
                                                var buttonid = $(this).attr('data-postid');
                                                $('.postcomment').attr("data-commentid", buttonid)
                                                $.ajax({
                                                        type: "GET",
                                                        url: "api/comments?postid=" + $(this).attr('data-postid'),
                                                        processData: false,
                                                        contentType: "application/json",
                                                        data: '',
                                                        success: function(r) {
                                                                var res = JSON.parse(r)
                                                                showCommentsModal(res);
                                                                console.log(r)
                                                        },
                                                        error: function(r) {
                                                                console.log(r)
                                                        }
                                                });
                                        });

                                        $('[data-id]').click(function() {

                                                var buttonid = $(this).attr('data-id');
                                                $.ajax({
                                                        type: "POST",
                                                        url: "api/likes?id=" + $(this).attr('data-id'),
                                                        processData: false,
                                                        contentType: "application/json",
                                                        data: '',
                                                        success: function(r) {
                                                                var res = JSON.parse(r)
                                                                $("[data-id='" + buttonid + "']").html('<p class="like-number">' + res.Likes + '</p>')
                                                        },
                                                        error: function(r) {
                                                                console.log(r)
                                                        }
                                                });
                                        })
                                })

                                $('.postimg').each(function() {
                                        this.src = $(this).attr('data-tempsrc')
                                        this.onload = function() {
                                                this.style.opacity = '1'
                                        }
                                })


                                scrollToAnchor(location.hash)
                        },
                        error: function(data) {
                                console.log(data)
                        }
                })
        })

        function showCommentsModal(res) {
                $('.modal').modal('show')
                var output = "";
                for (var i = 0; i < res.length; i++) {
                        output += "<p style='padding:4px;font-size:13.5px;'><b>"+res[i].CommentedBy+"</b>";
                        output += " ~ ";
                        output += res[i].Comment+"</p>";    
                        output += "<hr />";
                }
                $('.modal-body').html(output)
        }
        $('.postcomment').click(function() {
                if($('#comment_content').val() == "") {
            alert("Comment Filed cannot be empty")
            
                }
                var data = '{ "comment_data" : "' + $('#comment_content').val() + '"}'
                console.log(data)
                $.ajax({
                        type: "POST",
                        url: "api/postcomment?postid=" + $(this).attr('data-commentid'),
                        processData: false,
                        contentType: "application/json",
                        data: data,
                        success: function(res) {
                                $('#comment_content').val("")
                            
                        }
                })
        })

        //search 

        $('.sbox').focus(function () {
            $('.autocomplete').html("")
            $('.suggestions').css("display", "block")
        })
        $('body').click(function () {
            $('.autocomplete').html("")
        })

        $('.sbox').keyup(function () {
            $('.autocomplete').html("")
            $.ajax({
                type: "GET",
                url: "api/search?query=" + $(this).val(),
                processData: false,
                contentType: "application/json",
                data: '',
                success: function (r) {
                    r = JSON.parse(r)
                    for (var i = 0; i < r.length; i++) {
                        $('.autocomplete').html(
                            $('.autocomplete').html() +
                            '<a style="color:black;" href="profile.php?username='+r[i].username +'#'+r[i].id+'"><p class="list">' + r[i].body + ' ~ <b>' + r[i].username + '</b></p></a>'
                            
                        )
                    }
                },
                error: function (r) {
                    console.log(r)
                }
            })
        })

        $('#searchform').submit(function(e){
            e.preventDefault()
            $('.autocomplete').html("")
            $.ajax({
                type: "GET",
                url: "api/search-user?query=" + $('.sbox').val(),
                processData: false,
                contentType: "application/json",
                data: '',
                success: function (r) {
                    r = JSON.parse(r)
                    for (var i = 0; i < r.length; i++) {
                        $('.autocomplete').html(
                            $('.autocomplete').html() +
                            '<a style="color:black;" href="profile.php?username='+r[i].username +'"><p class="list">' + r[i].username + '</b></p></a>'   
                        )
                    }
                    
                },
                error: function (r) {
                    console.log(r)
                }
            })
        })

</script>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</html>