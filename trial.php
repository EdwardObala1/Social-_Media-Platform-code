<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
include('./classes/Image.php');
include('./classes/Notify.php');
?>

<?php 
echo DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']));
?>