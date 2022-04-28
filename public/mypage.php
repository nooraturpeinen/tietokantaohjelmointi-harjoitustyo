<?php
include TEMPLATES_DIR.'header.php';
?>
<style> <?php include BASE_DIR.'style.css' ?> </style>
<?php
include MODULES_DIR.'postandcomment.php';

if (isset($_SESSION["username"])) { ?>

<div class="container-fluid p-5">
    <div class="row mb-5">
        <div class="col-sm">
            <img src="../profile_pictures/<?php echo $_SESSION["picture"] ?>" id="mypagepfp">
        </div>
        <div class="col-sm">
            <h4><?php echo $_SESSION["username"] ?></h4>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm mb-2 d-flex justify-content-end">
                    <button type="button" class="mypagebutton"><a href="editprofile.php">Edit Profile</a></button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm d-flex justify-content-end">
                    <button type="button" class="mypagebutton"><a href="unregister.php" onclick="return confirm('Are you sure?')">Delete Account</a></button>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h5>My Posts</h5>
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