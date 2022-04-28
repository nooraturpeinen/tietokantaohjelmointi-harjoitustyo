<?php
include TEMPLATES_DIR.'header.php';
?>
<style> <?php include BASE_DIR.'style.css' ?> </style>
<?php
include MODULES_DIR.'postandcomment.php';

$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$post = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($_SESSION["username"]) && isset($title) && isset($post) && !empty($title) && !empty($post)) {
    try {
        createPost($title, $post);
        header('Location: index.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

if (isset($_SESSION["username"])) { ?>

<div class="container-fluid p-5">
    <h3>Welcome <?php echo $_SESSION["username"] ?>!</h3>
    <h5>Start a new discussion...</h5>
    <form action="index.php" method="post" id="postbox">
        <h6>Title</h6>
        <input type="text" name="title" required>
        <h6>Message</h6>
        <textarea name="post" required></textarea>
        <div>
            <button type="submit" class="postbutton">Post</button>
        </div>
    </form>
    <h5>...or join ongoing conversation!</h5>

<?php

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($_SESSION["username"]) && isset($post_id) && isset($comment) && !empty($post_id) && !empty($comment)) {
    try {
        createComment($post_id, $comment);
        header('Location: index.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}
    
$posts = allPosts();
foreach ($posts as $p) {
    echo "<div id='allposts'>
        <img src='../profile_pictures/".$p["picture"]."' id='postpicture'>
        <h5 id='postusername'>".$p["username"]."</h5>
        <small>".$p["created"]."</small>
        <hr>
        <h6 id='posttitle'>".$p["title"]."</h6>
        <p id='post'>".$p["post"]."</p>
    </div>";
    $comments = allComments($p["id"]);
    foreach ($comments as $c) {
        echo "<div id='allcomments'>
            <img src='../profile_pictures/".$c["picture"]."' id='commentpicture'>
            <h6 id='commentusername'>".$c["username"]."</h6>
            <small>".$p["created"]."</small>
            <p id='comment'>".$c["comment"]."</p>
        </div>";
    }
    echo "<form action='index.php?id=".$p["id"]."' method='post' class='commentbox'>
        <h6>Comment</h6>
        <textarea name='comment' required></textarea>
        <div>
            <button type='submit' class='postbutton'>Post</button>
        </div>
    </form>";
}
?>

</div>

<?php } else { ?>

<div class="container-fluid p-5">
    <h3>Welcome!</h3>
    <h5 id="introtext">Login to start a new discussion or join ongoing conversation.</h5>
    <?php
    $posts = allPosts();
    foreach ($posts as $p) {
        echo "<div id='allposts'>
            <img src='../profile_pictures/".$p["picture"]."' id='postpicture'>
            <h5 id='postusername'>".$p["username"]."</h5>
            <small>".$p["created"]."</small>
            <hr>
            <h6 id='posttitle'>".$p["title"]."</h6>
            <p id='post'>".$p["post"]."</p>
        </div>";
        $comments = allComments($p["id"]);
        foreach ($comments as $c) {
            echo "<div id='allcomments'>
                <img src='../profile_pictures/".$c["picture"]."' id='commentpicture'>
                <h6 id='commentusername'>".$c["username"]."</h6>
                <small>".$p["created"]."</small>
                <p id='comment'>".$c["comment"]."</p>
            </div>";
        }
    }
    ?>
</div>

<?php }

/*
$people = getPeople();
echo "<ul>";
foreach($people as $p){
    echo "<li>".$p["firstname"]." ".$p["lastname"].'<a href="people.php?id=' . $p["ID"] . '" class="btn btn-primary">Delete</a> </li>';
}
echo "</ul>";
*/

include TEMPLATES_DIR.'footer.php';
?>