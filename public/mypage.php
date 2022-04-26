<?php
include TEMPLATES_DIR.'header.php';
include MODULES_DIR.'postandcomment.php';

if (isset($_SESSION["username"])) { ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm">
            <img src="../profile_pictures/<?php echo $_SESSION["picture"] ?>">
            <!-- echo "<img src='../profile_pictures/".$_SESSION["picture"]."' >"; -->
        </div>
        <div class="col-sm">
            <h4><?php echo $_SESSION["username"] ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <button type="button"><a href="changepfp.php">Edit Profile</a></button>
            <button type="button"><a href="unregister.php" onclick="return confirm('Are you sure?')">Delete Account</a></button>
        </div>
    </div>
    <?php
    $posts = allUsersPosts();
    foreach ($posts as $p) {
        echo "<div>
            <h5>".$p["title"]."</h5>
            <h6>@".$p["username"]."</h6>
            <p>".$p["post"]."</p>
        </div>";
    }
    ?>
</div>

<?php }
include TEMPLATES_DIR.'footer.php';
?>