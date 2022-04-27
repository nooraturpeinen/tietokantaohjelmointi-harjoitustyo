<?php
include TEMPLATES_DIR.'header.php';
?>
<style> <?php include BASE_DIR.'style.css' ?> </style>
<?php
include MODULES_DIR.'editprofile.php';

if (isset($_FILES['picture'])) {
    $picture = filter_var_array($_FILES['picture']);
}

if (isset($picture)) {
    try {
        changeProfilePicture($picture);
        header('Location: mypage.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

if (isset($_SESSION["username"])) { ?>

<div class="container-fluid">
    <div>
        <h3>Change Profile Picture</h3>
    </div>
    <form action="changepfp.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="picture">Profile Picture:</label>
            <input type="file" name="picture" required/>
        </div>
        <div>
            <button type="submit">Save</button>
        </div>
    </form>
    <div>
        <button type="button"><a href="mypage.php">Cancel</a></button>
    </div>
    <div>
        <button type="button"><a href="changepw.php">Change Password</a></button>
    </div>
</div>

<?php }
include TEMPLATES_DIR.'footer.php';
?>