<?php
include TEMPLATES_DIR.'header.php';
include MODULES_DIR.'registration.php';
include MODULES_DIR.'authorization.php';

if (isset($_SESSION["username"])) {
    $id = $_SESSION["id"];
    try {
        unregister($id);
        logout();
        header('Location: index.php');
    } catch (Exception $e){
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

include TEMPLATES_DIR.'footer.php';