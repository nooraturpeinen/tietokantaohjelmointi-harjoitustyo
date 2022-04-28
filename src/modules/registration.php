<?php
function register($username, $pw, $picture) {
    require_once MODULES_DIR.'db.php';

    if (!isset($username) || !isset($pw)) {
        throw new Exception('Missing parameters.');
    }

    if (empty($username) || empty($pw)) {
        throw new Exception('Username and password must be included.');
    }

    try {
        if ($picture == 'blank_pfp.png') {
            $db = openDb();
            $sql = 'insert into `user` (username, pw, picture) values (?, ?, ?)';
            $statement = $db->prepare($sql);
            $statement->bindParam(1, $username);
            $hash_pw = password_hash($pw, PASSWORD_DEFAULT);
            $statement->bindParam(2, $hash_pw);
            $statement->bindParam(3, $picture);
            $statement->execute();
            $data = array('id' => $db->lastInsertId(), 'username' => $username, 'pw' => $hash_pw, 'picture' => $picture);
            echo json_encode($data);
        } else {
            $filename = $picture['name'];
            $path = PROFILE_PICTURES_DIR.basename($filename);
            move_uploaded_file($picture['tmp_name'], $path);
            $db = openDb();
            $sql = 'insert into `user` (username, pw, picture) values (?, ?, ?)';
            $statement = $db->prepare($sql);
            $statement->bindParam(1, $username);
            $hash_pw = password_hash($pw, PASSWORD_DEFAULT);
            $statement->bindParam(2, $hash_pw);
            $statement->bindParam(3, $filename);
            $statement->execute();
            $data = array('id' => $db->lastInsertId(), 'username' => $username, 'pw' => $hash_pw, 'picture' => $filename, 'filename' => $filename);
            echo json_encode($data);
        }
    } catch (PDOException $e){
        throw $e;
    }
}

function unregister($id) {
    require_once MODULES_DIR.'db.php';

    if (!isset($id)) {
        throw new Exception("Missing parameters.");
    }

    try {
        $db = openDb();
        $db->beginTransaction();
        $sql = 'delete from `user` where id = ?';
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        $db->commit();
    } catch (PDOException $e) {
        $db->rollBack();
        throw $e;
    }
}