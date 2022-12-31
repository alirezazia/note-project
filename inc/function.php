<?php
require_once 'db.php';
session_start();
// SET MESSAGE
function set_message($message_text){
    $_SESSION['message'] = $message_text;    
}
// SHOW MESSAGE
function show_message(){
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
        $_SESSION['logedin'] = $username;
        header('Location:../index.php');
    } else{
        set_message('کاربری با این نام پیدا نشد');
        header('Location:../login.php');
    }
}

// CHECK LOGIN
function check_login(){
    if(!isset($_SESSION['logedin'])){
        header('Location:login.php ');
    }
}

// DO LOGOUT
if(isset($_GET['logout'])){
    unset($_SESSION['logedin']);
}

// ADD NOTES
if(isset($_POST['user-note'])){
    $userNote = $_POST['user-note'];
    $user_id = getUser_id();
    $addNote = mysqli_query($db,"INSERT INTO notes (note_text,user_id) VALUES ('$userNote','$user_id')");
    if($addNote){
        header('Location: ../index.php');
    }
}

// GET NOTES
function getUserNotes($limit=0){
    global $db;
    $user_id = getUser_id();
    if($limit){
        $getNotes = mysqli_query($db,"SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY id DESC LIMIT $limit");
    } else{
        $getNotes = mysqli_query($db,"SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY id DESC");        
    }
    $userNotes = [];
    while($notes = mysqli_fetch_array($getNotes)){
        $userNotes[] = $notes;
    }
    return $userNotes;
}

// GET USER ID WHENE LOGGEDIN
function getUser_id(){
    $username = $_SESSION['logedin'];
    global $db;
    $getUser = mysqli_query($db,"SELECT * FROM users WHERE username = '$username'");
    $userArray = mysqli_fetch_array($getUser);
    return $userArray['id'];
}