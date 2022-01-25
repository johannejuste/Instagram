<?php

// ########### VALIDATION ######################
if( ! isset( $user_id) ){
  http_response_code(400);
  exit();  
}


// ########### UPDATE AND SEND EMAIL ######################
require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');

try{
  $q = $db->prepare('UPDATE users SET user_status = 0 WHERE user_uuid = :user_uuid');
  $q->bindValue(':user_uuid', $user_id);
  if($q->execute()){
  
 
  $sql = $db->prepare('SELECT * FROM users WHERE user_uuid = :user_uuid');
  $sql->bindValue(':user_uuid', $user_id);
  $sql->execute();
  $user = $sql->fetch();

  $user_name = $user['user_name'];
  $user_last_name = $user['user_last_name'];
  $user_email = $user['user_email'];
  
  require_once($_SERVER['DOCUMENT_ROOT'].'/views/send_emails/view_send_email_delete_user.php');
  
}

}catch(PDOException $ex){
  echo 'Oops, something went wrong';
}
