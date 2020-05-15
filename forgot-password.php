<?php
include('./classes/DB.php');
include('./classes/Mail.php');

if (isset($_POST['resetpassword'])) {

        $cstrong = True;
        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        $email = $_POST['email'];
        $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email'=>$email))[0]['id'];
        DB::query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
        Mail::sendMail('Forgot Password!', "<a href='http://localhost/tutorials/sn/change-password.php?token=$token'>http://localhost/tutorials/sn/change-password.php?token=$token</a>", $email);
        echo 'Email sent!';
}

?>
<!-- <h1>Forgot Password</h1>
<form action="forgot-password.php" method="post">
        <input type="text" name="email" value="" placeholder="Email ..."><p />
        <input type="submit" name="resetpassword" value="Reset Password">
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
    <div class="login-clean" method="post" action="login.php">
        <form action="forgot-password.php" method="post">
            <h2 class="sr-only">Forgot Password</h2>
            <div class="illustration"><i class="icon ion-ios-navigate"><h5>Forgot password</h5></i></div>
            <div class="form-group">
                <input class="form-control" type="text" name="email" value="" placeholder="Email...">
            </div>
            <div class="form-group">
               
            </div>
            <div class="form-group">
                <input name="resetpassword" class="btn btn-primary btn-block" method="post" action="login.php" id="login" type="submit" data-bs-hover-animate="shake" value="Reset password">
            </div><a href="login.php" class="forgot">Go to the login page</a></form>
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


