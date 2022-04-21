<?php
include TEMPLATES_DIR.'header.php';
include MODULES_DIR.'authorization.php';

if (isset($_SESSION['username'])) {
    logout();
    header('Location: logout.php');
} else {
    echo '<div class="alert alert-success" role="alert">Logout complete.</div>';
}

include TEMPLATES_DIR.'footer.php';
