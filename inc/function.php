<?php
require_once 'db.php';
// SET MESSAGE
function set_message($message_text){
    session_start();
    $_SESSION['message'] = $message_text;    
}
// SHOW MESSAGE
function show_message(){
    session_start();
    if(isset($_SESSION['message'])){
        echo '<div class="m-3 alert alert-warning">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
}
// ADD NEW USER
if(isset($_POST['do-submit'])){
    $display_name = $_POST['display-name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pass_conf = $_POST['pass-conf'];

    $check_user = mysqli_query($db,"SELECT * FROM users WHERE username = '$username'");

    if(mysqli_num_rows($check_user) > 0){
        // echo 'نام کابری با این نام از قبل موجود می باشد.';
        // session_start();
        // $_SESSION['message'] = 'کاربری با این نام کاربری قبلا ثبت شده است!';
        set_message('کاربری با این نام کاربری قبلا ثبت شده است!');
        header('Location:../register.php');
    } else {
        if($password != $pass_conf){
            // echo 'رمز عبور و تکرار رمز عبور یکسان نمی‌باشد.';
            // session_start();
            // $_SESSION['message'] = 'رمز عبور و تکرار آن یکسان نمی باشد.';
            set_message('رمز عبور و تکرار آن یکسان نمی باشد.');
            header('Location:../register.php');
        } else {
            $insert = mysqli_query($db ,"INSERT INTO users (display_name,username,password) VALUES ('$display_name','$username','$password')");
            if($insert){
                set_message('ثبت نام شما با موفقیت انجام شد میتوانید وارد شوید.');
                header('Location:../login.php');
            }        
        }
    }

    
}

//  LOGIN USER
if(isset($_POST['do-login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $check_user = mysqli_query($db,"SELECT * FROM users WHERE username ='$username' AND password = '$password' ");
    if(mysqli_num_rows($check_user) > 0 ){
        session_start();
        $_SESSION['logedin'] = $username;
        header('Location:../index.php');
    } else{
        set_message('کاربری با این نام پیدا نشد');
        header('Location:../login.php');
    }
}

// CHECK LOGIN
function check_login(){
    session_start();
    if(!isset($_SESSION['logedin'])){
        header('Location:login.php ');
    }
}

// DO LOGOUT
if(isset($_GET['logout'])){
    session_start();
    unset($_SESSION['logedin']);
}