<?php
include TEMPLATES_DIR.'header.php';

if (isset($_SESSION["username"])) {
    echo "<h1>Welcome ".$_SESSION["username"]."</h1>";
}else{
    echo "<h1>Welcome! Login or register to post or comment.</h1>";
}

include TEMPLATES_DIR.'footer.php';