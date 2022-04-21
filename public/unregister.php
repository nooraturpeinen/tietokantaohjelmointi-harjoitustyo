<?php
include TEMPLATES_DIR.'header.php';
include MODULES_DIR.'registration.php';
include MODULES_DIR.'authorization.php';

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    try {
        unregister($username);
        logout();
        header('Location: index.php');
    } catch (Exception $e){
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

include TEMPLATES_DIR.'footer.php';