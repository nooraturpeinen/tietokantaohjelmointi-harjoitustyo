<?php
include TEMPLATES_DIR.'header.php';
?>
<style> <?php include BASE_DIR.'style.css' ?> </style>
<?php
include MODULES_DIR.'postandcomment.php';

if (isset($_SESSION["username"])) { ?>

<div class="container-fluid m-4">
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
        echo "<div id='allposts'>
            <img src='../profile_pictures/".$p["picture"]."' id='postpicture'>
            <h5 id='postusername'>".$p["username"]."</h5>
            <hr>
            <h6 id='posttitle'>".$p["title"]."</h6>
            <p id='post'>".$p["post"]."</p>
        </div>";
        $comments = allUsersPostsComments($p["id"]);
        foreach ($comments as $c) {
            echo "<div id='allcomments'>
                <img src='../profile_pictures/".$c["picture"]."' id='commentpicture'>
                <h6 id='commentusername'>".$c["username"]."</h6>
                <p id='comment'>".$c["comment"]."</p>
            </div>";
        };
    }
    ?>
</div>

<?php }
include TEMPLATES_DIR.'footer.php';
?>