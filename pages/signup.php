<?php
require_once('../Private/initialize.php');

if (isset($_SESSION['logged']) && $_SESSION['logged'] == 'true') {
    redirect_to(url_for('index.php'));
}


$errorMessage = '';
$email = '';
$password = '';
if (is_post_request()) {
    // Handle form values inputed from the text fields
    if (empty($_POST["email"])) {
        $errorMessage = $errorMessage . "Email is required <br />";
    } else {
        $email = test_input($_POST["email"]);
    }
    if (empty($_POST["password"])) {
        $errorMessage = $errorMessage . "Password is required <br />";
    } elseif ($_POST["password"] !== $_POST["password-confirm"]) {
        $errorMessage = $errorMessage . "Passwords don\'t match <br />";
    } else {
        $password = test_input($_POST["password"]);
    }
    $emailErr = false;
    $passwordErr = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = true;
    }

    if ($emailErr) {
        $errorMessage = $errorMessage . "Email is invalid <br />";
    }

    if (empty($errorMessage)) {
        $auth = $factory->createAuth();
        $checkUser = true;
        try {
            $checkUser = $auth->getUserByEmail($email);
        } catch (\Throwable $th) {
            // echo_error("Auth", $th);
            $errorMessage .= $th->getMessage() . "<br />";
            $checkUser = null;
        }
        if ($checkUser == null) {
            // means new user, so create account
            try {
                $auth->createUserWithEmailAndPassword(
                    $email,
                    $pass
                );
                $_SESSION['logged'] = 'true';
                $_SESSION['email'] = $email;
                redirect_to(url_for('index.php'));
            } catch (\Throwable $th) {
                $errorMessage = $errorMessage . 'Create user error: ' . $th->getMessage() . "<br />";
            }
        } else {
            $errorMessage = $errorMessage . "User already exists <br />";
        }
    }
}
include(PRIVATE_PATH . '/shared_header.php');
?>

<div id="content">
    <div class="authenticate">
        <h1>Create Account</h1>
        <form action="" method="post">
            <dl>
                <dt>Email Id</dt>
                <dd><input type="text" name="email" value="<?php echo $email; ?>"></dd>
            </dl>
            <dl>
                <dt>Password</dt>
                <dd><input type="password" name="password" value="<?php echo $password; ?>"></dd>
            </dl>
            <dl>
                <dt>Confirm Password</dt>
                <dd><input type="password" name="password-confirm" value="<?php echo $password; ?>"></dd>
            </dl>
            <div id="operations">
                <input type="submit" class="slide-hover-left-1" value="Signup" />
            </div>
        </form>
        <br />
        <?php if (!empty($errorMessage)) { ?>
            <div class="errors">
                <?php echo $errorMessage; ?>
            </div>
        <?php } ?>

        <br />
        <div class="change-method">
            Already a user? <a href="<?php echo url_for('/pages/login.php') ?>" >Login</a> now
        </div>
    </div>
</div>

<?php
include(PRIVATE_PATH . '/shared_footer.php');
