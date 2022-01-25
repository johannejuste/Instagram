<?php

// ########### VALIDATION ######################

if( ! isset($_POST['user_email']) ){
  header('Location: /login');
  exit();  
}

if( ! isset($_POST['user_password']) ){
  header('Location: /login');
  exit();  
}

if( ! filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) ){
  header('Location: /login');
  exit();  
}

if( strlen($_POST['user_password']) < 2 || 
  strlen($_POST['user_password']) > 50 ){
  header('Location: /login');
  exit();  
}



// ########### SELECT user and login ######################

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');

try{
  $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email LIMIT 1');
  $q->bindValue(':user_email', $_POST['user_email']);
  $q->execute();
  $user = $q->fetch();

  if( ! $user ){
      $error_message = "Wrong credentials";
      header("Location: /login/error/$error_message");
      exit();
  }
  
  if( ! password_verify($_POST['user_password'], $user['user_password']) ){
    $error_message = "Wrong credentials";
    header("Location: /login/error/$error_message");
    exit();  
  }

  if( $user['user_status'] == 0 ){
    $error_message = "User doesn't exist (not active)";
    header("Location: /login/error/$error_message");
    exit();
  }


  session_start();
  $_SESSION['user_uuid'] = $user['user_uuid'];
  $_SESSION['profile_picture'] = $user['user_profile_picture'];
  $_SESSION['user_name'] = $user['user_name'];
  $_SESSION['user_last_name'] = $user['user_last_name'];
  $_SESSION['user_admin'] = $user['user_admin'];
  header('Location: /');
  exit();

}catch(PDOException $ex){
  echo 'Oops, something went wrong';
}
