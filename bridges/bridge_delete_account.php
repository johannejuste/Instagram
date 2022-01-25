<?php

// ########### VALIDATION ######################

if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_uuid'] ) ){
  header('Location: /login');
  exit();  
}



// ########### UPDATE user status (delete) ##############

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_obj.php');

session_start();
try{
    $q = $db->prepare("UPDATE users SET user_status = 0 WHERE user_uuid = :user_uuid AND user_status = :user_status");
    $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
    $q->bindValue(':user_status', 1);
    $q->execute();
   
    session_destroy();
    $update_message = "Your account has been deleted";
    header("Location: /login/update/$update_message");
    exit();
    
}catch(PDOException $ex){
  echo 'Oops, something went wrong';
  };