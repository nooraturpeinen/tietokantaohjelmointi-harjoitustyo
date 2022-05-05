<?php
include TEMPLATES_DIR.'header.php';
?>
<style> <?php include BASE_DIR.'style.css' ?> </style>
<?php
include MODULES_DIR.'editprofile.php';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($username) && !empty($username)) {
    try {
        changeUsername($username);
        header('Location: mypage.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

if (isset($_FILES['picture'])) {
    $picture = filter_var_array($_FILES['picture']);
}

if (isset($picture['name']) && !empty($picture['name'])) {
    try {
        changeProfilePicture($picture);
        header('Location: mypage.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

$pw = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($pw) && !empty($pw)) {
    try {
        changePassword($pw);
        echo '<div class="alert alert-success" role="alert">Password change successful.</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

if (isset($_SESSION["username"])) { ?>

<div class="container-fluid p-5">
    <div>
        <h4>Edit Profile</h4>
    </div>
    <form action="editprofile.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username"/>
        </div>
        <div>
            <label for="picture">Profile Picture:</label>
            <input type="file" name="picture"/>
        </div>
        <div>
            <label for="pw">Password:</label>
            <input type="password" name="pw"/>
        </div>
        <div>
            <button type="submit" id="editprofilebutton">Save</button>
        </div>
    </form>
    <div>
        <button type="button" id="canceleditbutton"><a href="mypage.php">Cancel</a></button>
    </div>
</div>

<?php }
include TEMPLATES_DIR.'footer.php';
?>