

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
        <form method="post">
            <h2 class="sr-only">You are Logged out</h2>
            <div class="illustration"><i class="icon ion-ios-navigate"><h4>"You are not logged in"</h4></i></div>
            <div class="form-group">
            <a href="create-account.php" name="Sign up" class="btn btn-primary btn-block"  id="confirm" type="submit" data-bs-hover-animate="shake">Sign up</a>
            </div>
           
            <div class="form-group">
                <a href="login.php" name="Sign in" class="btn btn-primary btn-block"   id="confirm" type="submit" data-bs-hover-animate="shake">Sign in</a>
            </div></form>
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



