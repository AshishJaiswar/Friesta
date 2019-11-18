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
        echo 'Not logged in';
        die();
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

?>

