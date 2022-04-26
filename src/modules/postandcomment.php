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
        $sql = 'insert into post (username, title, post) values (?, ?, ?)';
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $_SESSION["username"]);
        $statement->bindParam(2, $title);
        $statement->bindParam(3, $post);
        $statement->execute();
        $data = array('id' => $db->lastInsertId(), 'username' => $_SESSION["username"], 'title' => $title, 'post' => $post);
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
        $sql = 'insert into comment (post_id, username, comment) values (?, ?, ?)';
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $post_id);
        $statement->bindParam(2, $_SESSION["username"]);
        $statement->bindParam(3, $comment);
        $statement->execute();
        $data = array('id' => $db->lastInsertId(), 'post_id' => $post_id, 'username' => $_SESSION["username"], 'comment' => $comment);
        echo json_encode($data);
    } catch (PDOException $e){
        throw $e;
    }
}

function allPosts() {
    require_once MODULES_DIR.'db.php';

    try {
        $db = openDb();
        $sql = 'select * from post';
        $posts = $db->query($sql);

        return $posts->fetchAll();
    } catch (PDOException $e){
        throw $e;
    }
}

function allUsersPosts() {
    require_once MODULES_DIR.'db.php';

    $username = $_SESSION["username"];

    try {
        $db = openDb();
        $sql = "select * from post where username = '$username'";
        $posts = $db->query($sql);

        return $posts->fetchAll();
    } catch (PDOException $e){
        throw $e;
    }
}