<?php


// ##################### VALIDATION ############################

// ------------ ISSET
// to check if each post variables are declared. Returns false if the input is empty

if( ! isset($_POST['new_user_name'])){
  header('Location: /signup');
  exit();
}

if( ! isset($_POST['new_user_lastname'])){
  header('Location: /signup');
  exit();
}

if( ! isset($_POST['new_user_email'])){
  header('Location: /signup');
  exit();
}

if( ! isset($_POST['new_user_phone'])){
  header('Location: /signup');
  exit();
}

if( ! isset($_POST['new_user_password'])){
  header('Location: /signup');
  exit();
}

if( ! isset($_POST['new_user_confirm_password'])){
  header('Location: /signup');
  exit();
}

// #####################
// #####################


// ------------ NAME
if( strlen($_POST['new_user_name']) < 2 || strlen($_POST['new_user_name']) > 20) {
  $error_message = 'Name must be at least 2 characters and cannot be longer than 20 characters';
  header("Location: /signup/error/$error_message");
  exit();
};

// ------------ LAST NAME
if ( strlen($_POST['new_user_lastname']) < 2 || strlen($_POST['new_user_lastname']) > 20){
  $error_message = 'lastname must be at least 2 characters and cannot be longer than 20 characters';
  header("Location: /signup/error/$error_message");
  exit();
};

// ------------EMAIL
//                var    inputname       checks if its a valid email  
if( ! filter_var($_POST['new_user_email'], FILTER_VALIDATE_EMAIL)){
  $error_message = 'Invalid Email';
  header("Location: /signup/error/$error_message");
  exit();
};

// ------------ PHONE
// ^[1-9][0-9]{7}$
$regex = '/^[1-9]\d{7}$/'; // not start with a 0
if( !preg_match($regex, $_POST['new_user_phone'])){
  $error_message = 'Invalid phonenumber';
  header("Location: /signup/error/$error_message");
  exit();
  };

    
//------------ PASSWORD
  if( strlen($_POST['new_user_password']) < 8 || strlen($_POST['new_user_password']) > 50 ){
      $error_message = 'Password must be at least 8 characters and cannot be longer than 50 characters';
      header("Location: /signup/error/$error_message");
      exit();  
}

  if($_POST['new_user_password'] !== $_POST['new_user_confirm_password']){
    $error_message = 'Password doesnt match';
    header("Location: /signup/error/$error_message");
    exit();
  }


  // ##################################
  // ##################################
  // ##################################


 // ##################### INSERT values - create user #############

 require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_obj.php');

try{ 

  $user_id = bin2hex(random_bytes(16)); // 32 alphanumeric
  $user_name = $_POST['new_user_name'];
  $user_last_name = $_POST['new_user_lastname'];
  $user_email = $_POST['new_user_email'];

  $q = $db->prepare("INSERT INTO users (user_uuid, user_name, user_last_name, user_email, user_phone, user_password, user_status) VALUES (:user_uuid, :user_name, :user_last_name, :user_email, :user_phone, :user_password, :user_status)");
  $q->bindValue(':user_uuid', $user_id); 
  $q->bindValue(':user_name', $user_name);
  $q->bindValue(':user_last_name', $user_last_name);
  $q->bindValue(':user_email', $user_email);
  $q->bindValue(':user_phone', $_POST['new_user_phone']);
  $q->bindValue(':user_password', password_hash($_POST['new_user_password'], PASSWORD_DEFAULT));
  $q->bindValue(':user_status', 0);
  $q->execute();

  require_once($_SERVER['DOCUMENT_ROOT'].'/views/send_emails/view_send_email_welcome.php');

  $update_message = "Congratulations, your account has been successfully created. A verification link has been sent to your email";
  header("Location: /signup/update/$update_message");
  exit();

  }catch(PDOException $ex){
    echo 'Oops, something went wrong'; 
};


