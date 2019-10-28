<<<<<<< HEAD
<?php
include('classes/DB.php');
include('classes/Login.php');
include('./classes/Post.php');
include('./classes/Comment.php');
include('./classes/Search.php');
$showTimeline = False;
if (Login::isLoggedIn()) {

        $userid = Login::isLoggedIn();
        $showTimeline = True;
} else {
        die('Not logged in');
}

if (isset($_GET['postid'])) {
        Post::likePost($_GET['postid'], $userid);
}

if (isset($_POST['comment'])) {
        Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
}

if (isset($_POST['search'])) {
        Search::searchPosts();
}
?>




<?php
$followingposts = DB::query('SELECT posts.id, posts.body, posts.posted_at, posts.likes, users.`username` FROM users, posts, followers
WHERE posts.user_id = followers.user_id
AND users.id = posts.user_id
AND follower_id = :userid
ORDER BY posts.likes DESC;', array(':userid' => $userid));


$response = "[";
foreach ($followingposts as $post) {
        $response .= "{";
        $response .= '"PostId": ' . $post['id'] . ',';
        $response .= '"PostBody": "' . $post['body'] . '",';
        $response .= '"PostedBy": "' . $post['username'] . '",';
        $response .= '"PostDate": "' . $post['posted_at'] . '",';
        $response .= '"Likes": ' . $post['likes'] . '';
        $response .= "},";
}
$response = substr($response, 0, strlen($response) - 1);
$response .= "]";

echo $response;
=======
<?php
include('classes/DB.php');
include('classes/Login.php');
include('./classes/Post.php');
include('./classes/Comment.php');
include('./classes/Search.php');
$showTimeline = False;
if (Login::isLoggedIn()) {

        $userid = Login::isLoggedIn();
        $showTimeline = True;
} else {
        die('Not logged in');
}

if (isset($_GET['postid'])) {
        Post::likePost($_GET['postid'], $userid);
}

if (isset($_POST['comment'])) {
        Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
}

if (isset($_POST['search'])) {
        Search::searchPosts();
}
?>

<form action="index.php" method="post">
        <input type="text" placeholder="Search" name="searchbox">
        <input type="submit" value="Search" name="search">
</form>


<?php
$followingposts = DB::query('SELECT posts.id, posts.body, posts.likes, users.`username` FROM users, posts, followers
WHERE posts.user_id = followers.user_id
AND users.id = posts.user_id
AND follower_id = :userid
ORDER BY posts.likes DESC;', array(':userid' => $userid));


foreach ($followingposts as $post) {
        echo $post['body'] . " ~ " . $post['username'];
        echo "<form action='index.php?postid=" . $post['id'] . "' method='post'>";
        if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid' => $post['id'], ':userid' => $userid))) {
                echo "<input type='submit' name='like' value='Like'>";
        } else {
                echo "<input type='submit' name='unlike' value='Unlike'>";
        }
        echo "<span>" . $post['likes'] . " likes</span>
        </form>
        <form action='index.php?postid=" . $post['id'] . "' method='post'>
        <textarea name='commentbody' rows='3' cols='50'></textarea>
        <input type='submit' name='comment' value='Comment'>
        </form>
        ";
        Comment::displayComments($post['id']);
        echo "
        <hr /></br />";
}
>>>>>>> 14226c79fce92bcb97faa12b3af6bbe784836f0b
