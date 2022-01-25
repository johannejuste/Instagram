<?php

// ########### VALIDATION #################################


//----------------- ISSET
if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_uuid'] ) ){
  header('Location: /login');
  exit();  
}

if( ! isset($_POST['current_user_password'])){
  header('Location: /profile/edit');
  exit();
}

if( ! isset($_POST['edit_user_password'])){
  header('Location: /profile/edit');
  exit();
}

if( ! isset($_POST['edit_user_confirm_password'])){
  header('Location: /profile/edit');
  exit();
}


//----------------- PASSWORD
if( strlen($_POST['current_user_password']) < 8 || strlen($_POST['current_user_password']) > 50 ){
  $error_message = 'Password must be at least 8 characters and cannot be longer than 50 characters';
  header("Location: /profile/edit/$error_message");
  exit();  
}

if( strlen($_POST['edit_user_password']) < 8 || strlen($_POST['edit_user_password']) > 50 ){
  $error_message = 'Password must be at least 8 characters and cannot be longer than 50 characters';
  header("Location: /profile/edit/$error_message");
  exit();  
}

if($_POST['edit_user_password'] !== $_POST['edit_user_confirm_password']){
  $error_message = 'Password doesnt match';
  header("Location: /profile/edit/$error_message");
  exit();
}




// ########### SELECT and UPDATE password #######################

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');

try{
  $q = $db->prepare("SELECT user_password FROM users WHERE user_uuid = :user_uuid");
  $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
  $q->execute();
  $user = $q->fetch();
  
  if( ! $user ){
    $error_message = "Wrong credentials";
    header("Location: /profile/edit/$error_message");
    exit();
  }
  
  if( ! password_verify($_POST['current_user_password'], $user['user_password']) ){
    $error_message = "Wrong credentials match";
    header("Location: /profile/edit/$error_message");
    exit();  
  }

    $q = $db->prepare("UPDATE users SET user_password = :edit_user_password WHERE user_uuid = :user_uuid");
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':edit_user_password', password_hash($_POST['edit_user_password'], PASSWORD_DEFAULT));
    $q->execute();

    $update_message = "Your profile has been updated";
    header("Location: /profile/edit/$update_message");
    exit();
    
}catch(PDOException $ex){
    echo 'Oops, something went wrong';
  };