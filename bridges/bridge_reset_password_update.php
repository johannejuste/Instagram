<?php

// ########### VALIDATION ######################

if( ! isset( $_POST['user_id'] ) ){
    header('Location: /reset-password/$user_id');
    exit();
}

if( ! isset($_POST['new_reset_password']) ){
    header('Location: /reset-password/$user_id');
    exit();
}

if( strlen($_POST['new_reset_password']) < 8 || strlen($_POST['new_reset_password']) > 50 ){
    $error_message = 'Password must be at least 8 characters and cannot be longer than 50 characters';
    header("Location: /reset-password/error/$error_message");
    exit();  
}

if($_POST['confirm_new_reset_password'] !== $_POST['confirm_new_reset_password']){
    $error_message = 'Password doesnt match';
    header("Location: /reset-password/error/$error_message");
    exit();
}




// ########### UPDATE user with password ##################

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');

try{

    $user_id = $_POST['user_id'];

    $q = $db->prepare('UPDATE users SET user_password = :user_password WHERE user_uuid = :user_uuid');
    $q->bindValue(':user_uuid', $user_id);
    $q->bindValue(':user_password', password_hash($_POST['new_reset_password'], PASSWORD_DEFAULT));
    $q->execute();

    header("Location: /reset-password-success/$user_id");
    exit();

}catch(PDOException $ex){
    echo 'Oops, something went wrong';
  }
  

