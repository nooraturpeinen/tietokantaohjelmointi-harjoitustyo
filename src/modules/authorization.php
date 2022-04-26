<?php
function login($username, $pw) {
    require_once MODULES_DIR.'db.php';

    if (!isset($username) || !isset($pw)) {
        throw new Exception("Missing parameters.");
    }

    if (empty($username) || empty($pw)) {
        throw new Exception("Username and password must be included.");
    }

    try {
        $db = openDb();
        $sql = 'select id, username, pw, picture from `user` where username = ?';
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $username);
        $statement->execute();

        if ($statement->rowCount() <= 0) {
            throw new Exception("User not found.");
        }

        $row = $statement->fetch();

        if (!password_verify($pw, $row["pw"])) {
            throw new Exception("Incorrect password.");
        }

        $_SESSION["username"] = $row["username"];
        $_SESSION["id"] = $row["id"];
        $_SESSION["pw"] = $row["pw"];
        $_SESSION["picture"] = $row["picture"];
    } catch (PDOException $e){
        throw $e;
    }
}

function logout() {
    try {
        session_unset();
        session_destroy();
    } catch (Exception $e){
        throw $e;
    }
}