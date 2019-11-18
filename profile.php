<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Image.php');
include('./classes/Notify.php');

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
</head>

<body>
        <div class="header">
                <div class="logo">
                        <a href="#">
                                <h1 id="friesta">Friesta</h1>
                        </a>
                </div>
                <div class="search">
                        <input type="text" placeholder="Search" class="search-input">
                        <button type="submit">Search</button>
                </div>
                <div class="nav-links">
                        <ul class="links">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Chats</a></li>
                                <li><a href="#">Notifications</a></li>
                                <li><a href="#">My Profile</a></li>
                        </ul>
                </div>
        </div>

        <div class="container">
                <div class="profile-image">
                        <div class="profile-div">
                                <div class="circle">
                                        <img class="default-image" src="pages/images/user.png">
                                </div>
                        </div>
                        <div class="edit">
                                <button class="edit-btn">Edit Profile</button>
                        </div>
                </div>
                <div class="info">
                        <div class="user-detail">
                                <div class="name-address">
                                        <h1 class="name"><?php if($name != null){echo $name[0]['fullname'];} ?><?php if ($verified) {
                                                                                        echo "<span><img class='verified' src='pages/images/verified.png'></span>";
                                                                                }  ?></h1>
                                        <p id="u" style="color:#0984e3;font-size:14px;">@<?php echo $username; ?></p>
                                        <p class="location"><span><?php if ($lives_in != null) {
                                                                                echo '<img class="location-icon" src="pages/images/location-gray-512.png">';
                                                                        } ?></span><?php if($lives_in != null){echo $lives_in[0]['lives_in']; }?></p>
                                </div>
                                <div class="other-detail">
                                        <p> <?php if ($relationship != null) {
                                                        echo "<b>Relationship ~ </b>" ;
                                                } ?><span><?php if($relationship != null){echo $relationship[0]['relationship'];} ?></span> </p>
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
                                        <button class="follow-user">Follow</button>
                                        <button class="unfollow-user" hidden="hidden">Unfollow</button>
                                </div>
                                <div class="message">
                                        <button class="message-user">Message</button>
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
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Comments</h4>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto">
                            <p>The content of your modal.</p>
                        </div>
                        <div class="modal-footer"><button class="btn btn-light" type="button"
                                data-dismiss="modal">Close</button></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
</body>
<script type="text/javascript">

function scrollToAnchor(aid){
    var aTag = $(aid);
        $('html,body').animate({scrollTop: aTag.offset().top},'slow');
    }

    $(document).ready(function () {
        $.ajax({
            type: 'GET',
            url: "api/profileposts?username=<?php echo $username; ?>",
            processData: false,
            contentType: 'application/json',
            data: '',
            success: function (data) {
                var posts = JSON.parse(data)
                $.each(posts, function (index) {
                    var d = new Date(posts[index].PostDate);
                    timeline = '<div class="user-posts" id='+posts[index].PostId+'><div class="username">\
                        <div class="profile-logo">\
                            <img src="#">\
                        </div>\
                        <h3 class="user_name"><a id="user-link" href="profile.php?username='+ posts[index].PostedBy + '">' + posts[index].PostedBy + '</a></h3>\
                    </div>\
                    <div class="time">\
                        <span  style="font-size:9px;position:relative;top:10px;right:-5px;margin-top:20px;">'+ d.toDateString() + '</span>\
                    </div>\
                    <div class="posted-area">\
                        <p> '+ posts[index].PostBody + '\
                        </p>\
                    </div>\
                    <div class="like-comment">\
                        <div class="like">\
                            <div class="heart" data-id="'+ posts[index].PostId + '">\
                                <p class="like-number">'+ posts[index].Likes + '</p>\
                            </div>\
                        </div>\
                        <div class="comment"  data-postid="'+ posts[index].PostId + '" >\
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
                    $('.timeline').html(
                        $('.timeline').html() + timeline
                    )

                    $('[data-postid]').click(function () {
                        var buttonid = $(this).attr('data-postid');
                        $.ajax({
                            type: "GET",
                            url: "api/comments?postid=" + $(this).attr('data-postid'),
                            processData: false,
                            contentType: "application/json",
                            data: '',
                            success: function (r) {
                                var res = JSON.parse(r)
                                showCommentsModal(res);

                            },
                            error: function (r) {
                                console.log(r)
                            }
                        });
                    });

                    $('[data-id]').click(function () {

                        var buttonid = $(this).attr('data-id');
                        $.ajax({
                            type: "POST",
                            url: "api/likes?id=" + $(this).attr('data-id'),
                            processData: false,
                            contentType: "application/json",
                            data: '',
                            success: function (r) {
                                var res = JSON.parse(r)
                                $("[data-id='" + buttonid + "']").html('<p class="like-number">' + res.Likes + '</p>')
                            },
                            error: function (r) {
                                console.log(r)
                            }
                        });
                    })
                })
                scrollToAnchor(location.hash)
            },
            error: function (data) {
                console.log(data)
            }
        })
    })
    function showCommentsModal(res) {
        $('.modal').modal('show')
        var output = "";
        for (var i = 0; i < res.length; i++) {
            output += res[i].Comment;
            output += " ~ ";
            output += res[i].CommentedBy;
            output += "<hr />";
        }
        $('.modal-body').html(output)
    }
</script>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</html>