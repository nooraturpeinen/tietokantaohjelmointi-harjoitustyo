<?php
include TEMPLATES_DIR.'header.php';
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

<div class="container-fluid">
    <h3>Welcome <?php echo $_SESSION["username"] ?>!</h3>
    <h5>Start a new discussion...</h5>
    <form action="index.php" method="post">
        <h6>Title</h6>
        <input type="text" name="title" required>
        <h6>Message</h6>
        <textarea name="post" required></textarea>
        <div>
            <button type="submit">Post</button>
        </div>
    </form>
    <?php
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
        $post_id = $p["postid"];

        echo "<div id='postbox'>
            <h5>".$p["title"]."</h5>
            <h6>@".$p["postusername"]."</h6>
            <p>".$p["post"]."</p>
            <div>
            <h6>".$p["commentusername"]."</h6>
            <p>".$p["commentcomment"]."</p>
            </div>
            <form action='index.php' method='post'>
                <h6>Comment</h6>
                <textarea name='comment' required></textarea>
                <div>
                    <button type='submit'>Post</button>
                </div>
            </form>
        </div>";
    }
    ?>
</div>

<?php } else { ?>

<div class="container-fluid">
    <h3>Welcome!</h3>
    <h5>Login to start a new discussion or join ongoing conversation.</h5>
    <?php
    $posts = allPosts();
    foreach ($posts as $p) {
        echo "<div>
            <h5>".$p["title"]."</h5>
            <h6>@".$p["username"]."</h6>
            <p>".$p["post"]."</p>
        </div>";
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