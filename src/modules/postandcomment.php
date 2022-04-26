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
        $sql = 'select post.id as postid, post.username as postusername, title, post, post.created, IFNULL(comment.id, ""), IFNULL(comment.username, "") as commentusername, IFNULL(comment.comment, "") as commentcomment, IFNULL(comment.created, "") from post left outer join comment on post.id = comment.post_id';
        $posts = $db->query($sql);

        return $posts->fetchAll();
    } catch (PDOException $e){
        throw $e;
    }
}

/*
create table post (
    id int primary key not null auto_increment,
    username varchar(25) not null,
    title varchar(150) not null,
    post text not null,
    created timestamp default current_timestamp not null,
    updated datetime,
    foreign key (username) references `user`(username)
);

create table comment (
    id int primary key not null auto_increment,
    post_id int not null,
    username varchar(25) not null,
    comment text not null,
    created timestamp default current_timestamp not null,
    updated datetime,
    foreign key (post_id) references post(id),
    foreign key (username) references `user`(username)
);
 */

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