<?php

// ########### VALIDATION ######################

if( ! isset($_POST['user_email']) ){
  header('Location: /reset-password-with-email');
  exit();  
}

if( ! filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) ){
  $error_message = 'Invalid Email';
  header("Location: /reset-password-with-email/error/$error_message");
  exit();  
}



// ########### SELECT user and send email ######################

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');

try{
  $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email LIMIT 1');
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->execute();
  $user = $q->fetch();

  if( ! $user ){
    $error_message = "No user with this email exist";
    header("Location: /reset-password-with-email/error/$error_message");
    exit();
  }
  

  $user_name = $user['user_name'];
  $user_last_name = $user['user_last_name'];
  $user_email = $user['user_email'];
  $user_id = $user['user_uuid'];
  
  session_start();
  $_SESSION['user_uuid'] = $user['user_uuid'];


  require_once($_SERVER['DOCUMENT_ROOT'].'/views/send_emails/view_send_email_reset_password.php');
  header('Location: /reset-password-email-sent');
  exit();

}catch(PDOException $ex){
    echo 'Oops, something went wrong';
  }
  