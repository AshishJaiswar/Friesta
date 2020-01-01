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

if (isset($_GET['post'])) {
        echo $_GET['post'];
}


?>




<?php
$followingposts = DB::query('SELECT posts.id, posts.body, posts.posted_at, posts.postimg, posts.likes,users.username,users.profileimg FROM posts LEFT JOIN followers on followers.user_id = posts.user_id
LEFT JOIN users on users.id = posts.user_id
WHERE follower_id=:userid OR posts.user_id=:userid
ORDER BY posts.likes DESC ;', array(':userid' => $userid), array(':userid' => $userid));


$response = "[";

foreach ($followingposts as $post) {
        $response .= "{";
        $response .= '"PostId": ' . $post['id'] . ',';
        $response .= '"PostBody": "' . $post['body'] . '",';
        $response .= '"PostedBy": "' . $post['username'] . '",';
        $response .= '"PostDate": "' . $post['posted_at'] . '",';
        $response .= '"PostImage": "' . $post['postimg'] . '",';
        $response .= '"ProfileImg": "' . $post['profileimg'] . '",';
        $response .= '"Likes": ' . $post['likes'] . '';
        $response .= "},";
}
$response = substr($response, 0, strlen($response) - 1);
$response .= "]";

echo $response;

?>

