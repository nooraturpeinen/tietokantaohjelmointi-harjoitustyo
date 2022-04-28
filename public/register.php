<?php
include TEMPLATES_DIR.'header.php';
?>
<style> <?php include BASE_DIR.'style.css' ?> </style>
<?php
include MODULES_DIR.'registration.php';
include MODULES_DIR.'authorization.php';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$pw = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($_FILES['picture'])) {
    $picture = filter_var_array($_FILES['picture']);
}
if (empty($_FILES['picture']['name'])) {
    $picture = 'blank_pfp.png';
}

if (isset($username) && isset($pw)) {
    try {
        register($username, $pw, $picture);
        login($username, $pw);
        header('Location: index.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}
?>

<div class="container-fluid p-5">
    <div>
        <h3>Register</h3>
    </div>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" required/>
        </div>
        <div>
            <label for="pw">Password:</label>
            <input type="password" name="pw" required/>
        </div>
        <div>
            <label for="picture">Profile Picture:</label>
            <input type="file" name="picture"/>
        </div>
        <div>
            <button type="submit" class="loginregisterbutton">Register</button>
        </div>
    </form>
    <div>
        <p>Already a user? <a href="login.php">Login</a></p>
    </div>
</div>

<?php
include TEMPLATES_DIR.'footer.php';
?>