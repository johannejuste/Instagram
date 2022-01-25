<?php

// ########### VALIDATION ####################################

if( ! isset($_POST['email'])){
  http_response_code(400);
  exit();
};

if( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
  http_response_code(400);
  exit();
};



// ########### SELECT user_email in database ##################

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');

try{
    $q = $db->prepare('SELECT user_email FROM users WHERE user_email = :user_email');
    $q->bindValue(':user_email', $_POST['email']);
    $q->execute();
    $email = $q->fetch();
 
    if( ! $email ){
    echo 'available'; // response code 200
  } else {
    http_response_code(400);
    exit();
  }

}catch(PDOException $ex){
    echo 'Oops, something went wrong';
  };