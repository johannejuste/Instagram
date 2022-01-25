<?php

// ########### VALIDATION ######################

if( ! isset( $user_id) ){
    header('Location: /signup');
    exit();  
  }



// ########### UPDATE user - active ######################

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');

try{
    $q = $db->prepare("UPDATE users SET user_status = 1 WHERE user_uuid = :user_uuid AND user_status = :user_status");
    $q->bindValue(':user_uuid', $user_id);
    $q->bindValue(':user_status', 0);
    $q->execute();
    
        header("Location: /verify-success/$user_id");
        exit();

}catch(PDOException $ex){
    echo 'Oops, something went wrong';
  };