<?php

function changeProfilePicture($picture) {
    require_once MODULES_DIR.'db.php';

    if (!isset($picture)) {
        throw new Exception('Missing parameters.');
    }

    if (empty($picture)) {
        throw new Exception('Profile picture must be included.');
    }

    try {
        $filename = $picture['name'];
        $path = PROFILE_PICTURES_DIR.basename($filename);
        move_uploaded_file($picture['tmp_name'], $path);
        $db = openDb();
        $sql = 'update `user` set picture = ? where id = ?';
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $filename);
        $statement->bindParam(2, $_SESSION["id"]);
        $statement->execute();

        $_SESSION["picture"] = $filename;
    } catch (PDOException $e){
        throw $e;
    }
}

function changePassword($pw) {
    require_once MODULES_DIR.'db.php';

    if (!isset($pw)) {
        throw new Exception('Missing parameters.');
    }

    if (empty($pw)) {
        throw new Exception('Password must be included.');
    }

    try {
        $db = openDb();
        $sql = 'update `user` set pw = ? where id = ?';
        $statement = $db->prepare($sql);
        $hash_pw = password_hash($pw, PASSWORD_DEFAULT);
        $statement->bindParam(1, $hash_pw);
        $statement->bindParam(2, $_SESSION["id"]);
        $statement->execute();

        $_SESSION["pw"] = $hash_pw;
    } catch (PDOException $e){
        throw $e;
    }
}