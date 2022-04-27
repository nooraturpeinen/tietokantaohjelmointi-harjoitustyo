<?php
include TEMPLATES_DIR.'header.php';
?>
<style> <?php include BASE_DIR.'style.css' ?> </style>
<?php
include MODULES_DIR.'editprofile.php';

$pw = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($pw)) {
    try {
        changePassword($pw);
        header('Location: mypage.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

if (isset($_SESSION["username"])) { ?>

<div class="container-fluid">
    <div>
        <h3>Change Password</h3>
    </div>
    <form action="changepw.php" method="post">
        <div>
            <label for="pw">Password:</label>
            <input type="password" name="pw" required/>
        </div>
        <div>
            <button type="submit">Save</button>
        </div>
    </form>
    <div>
        <button type="button"><a href="mypage.php">Cancel</a></button>
    </div>
</div>

<?php }
include TEMPLATES_DIR.'footer.php';
?>