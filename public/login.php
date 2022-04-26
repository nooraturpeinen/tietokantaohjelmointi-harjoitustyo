<?php
include TEMPLATES_DIR.'header.php';
include MODULES_DIR.'authorization.php';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$pw = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($_SESSION['username']) && isset($username) && isset($pw)) {
    try {
        login($username, $pw);
        header('Location: index.php');
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
    }
}

if (!isset($_SESSION['username'])) {

?>

<div class="container-fluid">
    <div>
        <h3>Login</h3>
    </div>
    <form action="login.php" method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" required/>
        </div>
        <div>
            <label for="pw">Password:</label>
            <input type="password" name="pw" required/>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    <div>
        <p>Not a user yet? <a href="register.php">Register</a></p>
    </div>
</div>

<?php }
include TEMPLATES_DIR.'footer.php';
?>