<?php
include('./classes/DB.php');
include('./classes/Login.php');
$tokenIsValid = False;
if (Login::isLoggedIn()) {

        if (isset($_POST['changepassword'])) {

                $oldpassword = $_POST['oldpassword'];
                $newpassword = $_POST['newpassword'];
                $newpasswordrepeat = $_POST['newpasswordrepeat'];
                $userid = Login::isLoggedIn();

                if (password_verify($oldpassword, DB::query('SELECT password FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['password'])) {

                        if ($newpassword == $newpasswordrepeat) {

                                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {

                                        DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                        echo 'Password changed successfully!';
                                }

                        } else {
                                echo "Passwords don't match!";
                        }

                } else {
                        echo 'Incorrect old password!';
                }

        }

} else {
        if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if (DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))) {
                $userid = DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $tokenIsValid = True;
                if (isset($_POST['changepassword'])) {

                        $newpassword = $_POST['newpassword'];
                        $newpasswordrepeat = $_POST['newpasswordrepeat'];

                                if ($newpassword == $newpasswordrepeat) {

                                        if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {

                                                DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                                echo 'Password changed successfully!';
                                                DB::query('DELETE FROM password_tokens WHERE user_id=:userid', array(':userid'=>$userid));
                                        }

                                } else {
                                        echo "Passwords don't match!";
                                }

                        }


        } else {
                die('Token invalid');
        }
} else {
        header("Location:statement.php");
}
}
?>
<!-- <h1>Change your Password</h1>
<form action="
<?php 
// if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } 
?>
" method="post">
        <?php 
        // if (!$tokenIsValid) { echo '<input type="password" name="oldpassword" value="" placeholder="Current Password ..."><p />'; } 
        ?>
        <input type="password" name="newpassword" value="" placeholder="New Password ..."><p />
        <input type="password" name="newpasswordrepeat" value="" placeholder="Repeat Password ..."><p />
        <input type="submit" name="changepassword" value="Change Password">
</form> -->



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialNetwork</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="login-clean" method="post" action="change-password.php">
        <form action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } ?>" method="post">
            <h2 class="sr-only">Change your password</h2>
            <div class="illustration"><i class="icon ion-ios-navigate"></i></div>
            <div class="form-group">
                <!-- <input class="form-control" type="password" value="" name="oldpassword"  placeholder="Current Password..."> -->
                <?php if (!$tokenIsValid) { echo '<input class="form-control" type="password" name="oldpassword" value="" placeholder="Current Password ..."><p />'; } ?>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" value="" name="newpassword" placeholder="New Password">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" value="" name="newpasswordrepeat" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <input name="changepassword" class="btn btn-primary btn-block" method="post" action="login.php" value="Change Password" type="submit" data-bs-hover-animate="shake">
            </div><a href="forgot-password.php" class="forgot">Forgot your email or password?</a></form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="assets/js/bs-animation.js"></script> -->
    <script type="text/javascript">
        $('#login').click(function() {

                $.ajax({

                        type: "POST",
                        url: "api/auth",
                        processData: false,
                        contentType: "application/json",
                        data: '{ "username": "'+ $("#username").val() +'", "password": "'+ $("#password").val() +'" }',
                        success: function(r) {
                                console.log(r)
                        },
                        error: function(r) {
                                setTimeout(function() {
                                $('[data-bs-hover-animate]').removeClass('animated ' + $('[data-bs-hover-animate]').attr('data-bs-hover-animate'));
                                }, 2000)
                                $('[data-bs-hover-animate]').addClass('animated ' + $('[data-bs-hover-animate]').attr('data-bs-hover-animate'))
                                console.log(r)
                        }

                });

        });
    </script>
</body>




