<?php
function createPost($title, $post) {
    require_once MODULES_DIR.'db.php';

    if (!isset($title) || !isset($post)) {
        throw new Exception('Missing parameters.');
    }

    if (empty($title) || empty($post)) {
        throw new Exception('Title and post must be included.');
    }

    try {
        $db = openDb();
        $sql = 'insert into post (user_id, title, post) values (?, ?, ?)';
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $_SESSION["id"]);
        $statement->bindParam(2, $title);
        $statement->bindParam(3, $post);
        $statement->execute();
        $data = array('id' => $db->lastInsertId(), 'user_id' => $_SESSION["id"], 'title' => $title, 'post' => $post);
        echo json_encode($data);
    } catch (PDOException $e){
        throw $e;
    }
}

function createComment($post_id, $comment) {
    require_once MODULES_DIR.'db.php';

    if (!isset($post_id) || !isset($comment)) {
        throw new Exception('Missing parameters.');
    }

    if (empty($post_id) || empty($comment)) {
        throw new Exception('Post ID and comment must be included.');
    }

    try {
        $db = openDb();
        $sql = 'insert into comment (post_id, user_id, comment) values (?, ?, ?)';
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $post_id);
        $statement->bindParam(2, $_SESSION["id"]);
        $statement->bindParam(3, $comment);
        $statement->execute();
        $data = array('id' => $db->lastInsertId(), 'post_id' => $post_id, 'user_id' => $_SESSION["id"], 'comment' => $comment);
        echo json_encode($data);
    } catch (PDOException $e){
        throw $e;
    }
}

function allPosts() {
    require_once MODULES_DIR.'db.php';

    try {
        $db = openDb();
        $sql = 'select post.id as id, user.username as username, title, post, created, updated, picture from post inner join user on post.user_id = user.id';
        $posts = $db->query($sql);

        return $posts->fetchAll();
    } catch (PDOException $e){
        throw $e;
    }
}

function allComments($post_id) {
    require_once MODULES_DIR.'db.php';

    try {
        $db = openDb();
        $sql = 'select comment.id as id, post_id, user.username as username, comment, created, updated, picture from comment inner join user on comment.user_id = user.id where post_id = ?';
        $comments = $db->prepare($sql);
        $comments->bindParam(1, $post_id);
        $comments->execute();
        
        return $comments->fetchAll();
    } catch (PDOException $e){
        throw $e;
    }
}

function allUsersPosts() {
    require_once MODULES_DIR.'db.php';

    $user_id = $_SESSION["id"];

    try {
        $db = openDb();
        $sql = 'select post.id as id, user.username as username, title, post, created, updated, picture from post inner join user on post.user_id = user.id where user_id = ?';
        $posts = $db->prepare($sql);
        $posts->bindParam(1, $user_id);
        $posts->execute();
        
        return $posts->fetchAll();
    } catch (PDOException $e){
        throw $e;
    }
}

function allUsersPostsComments($post_id) {
    require_once MODULES_DIR.'db.php';

    try {
        $db = openDb();
        $sql = 'select comment.id as id, post_id, user.username as username, comment, created, updated, picture from comment inner join user on comment.user_id = user.id where post_id = ?';
        $comments = $db->prepare($sql);
        $comments->bindParam(1, $post_id);
        $comments->execute();
        
        return $comments->fetchAll();
    } catch (PDOException $e){
        throw $e;
    }
}