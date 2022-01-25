<?php


// ########### VALIDATION #################################


//----------------- ISSET
if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_uuid'] ) ){
  header('Location: /login');
  exit();  
}

if( ! isset($_POST['edit_user_name'])){
    header('Location: /profile/edit');
    exit();
  }
  
  if( ! isset($_POST['edit_user_lastname'])){
    header('Location: /profile/edit');
    exit();
  }
  
  if( ! isset($_POST['edit_user_email'])){
    header('Location: /profile/edit');
    exit();
  }
  
  if( ! isset($_POST['edit_user_phone'])){
    header('Location: /profile/edit');
    exit();
  }

 // #########################


// ------------ NAME
if( strlen($_POST['edit_user_name']) < 2 || strlen($_POST['edit_user_name']) > 20) {
    $error_message = 'Name must be at least 2 characters and cannot be longer than 20 characters';
    header("Location: /profile/edit/$error_message");
    exit();
  };
  
  // ------------ LAST NAME
  if ( strlen($_POST['edit_user_lastname']) < 2 || strlen($_POST['edit_user_lastname']) > 20){
    $error_message = 'lastname must be at least 2 characters and cannot be longer than 20 characters';
    header("Location: /profile/edit/$error_message");
    exit();
  };
  
  // ------------EMAIL
  //                var    inputname       checks if its a valid email  
  if( ! filter_var($_POST['edit_user_email'], FILTER_VALIDATE_EMAIL)){
    $error_message = 'Invalid Email';
    header("Location: /profile/edit/$error_message");
    exit();
  };
  
  // ------------ PHONE
  $regex = '/^[1-9]\d{7}$/'; // not start with a 0
  if( !preg_match($regex, $_POST['edit_user_phone'])){
    $error_message = 'Invalid phone number';
    header("Location: /profile/edit/$error_message");
    exit();
    };


// #########################
// #########################
// #########################


// ########### SELECT and UPDATE profile details ###############

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_obj.php');

try{
    $q = $db->prepare("UPDATE users SET user_name=:user_name, user_last_name = :user_last_name, 
    user_email = :user_email, user_phone= :user_phone WHERE user_uuid = :user_uuid");
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':user_name', $_POST['edit_user_name']);
    $q->bindValue(':user_last_name', $_POST['edit_user_lastname']);
    $q->bindValue(':user_email', $_POST['edit_user_email']);
    $q->bindValue(':user_phone', $_POST['edit_user_phone']);
    $q->execute();
   
    $update_message = "Your profile has been updated";
    header("Location: /profile/edit/$update_message");
    exit();
   
}catch(PDOException $ex){
    echo 'Oops, something went wrong';
  };