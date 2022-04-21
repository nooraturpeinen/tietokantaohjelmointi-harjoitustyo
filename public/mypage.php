<?php
include TEMPLATES_DIR.'header.php';

if (isset($_SESSION["username"])) {
    echo "<h1>Welcome ".$_SESSION["username"]."</h1>";
}
?>

<div>
    <button type="button"><a href="unregister.php" onclick="return confirm('Are you sure?');">Delete Account</a></button>
</div>

<?php
include TEMPLATES_DIR.'footer.php';
?>