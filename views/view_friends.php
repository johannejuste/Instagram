<?php
// ######### TOP
require_once(__DIR__.'/view_top.php');


// ######### VALIDATION
if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_uuid'] ) ){
  header('Location: /profile');
  exit();  
}



// ######### SELECT users - show users #############
require_once(__DIR__.'/../db/db_assoc.php');

try{
  $q = $db->prepare('SELECT * FROM users');
  $q->execute();
  $users = $q->fetchAll();
  
  foreach($users as $user){
    unset($user['user_password']);
  ?>
<div class="user">
  <img style="width: 100px;" src="<?= $user['user_profile_picture']?>" alt="profile_picture">
  <div>ID: <?= $user['user_uuid'] ?></div>
  <div>NAME: <?= $user['user_name'] ?></div>
  <div>LAST NAME: <?= $user['user_last_name'] ?></div>
  <div>EMAIL: <?= $user['user_email'] ?></div>
  <div>PHONE: <?= $user['user_phone'] ?></div>

</div>
<?php
  }
}catch(PDOException $ex){
  echo 'Oops, something went wrong'; 
}


// Bottom
require_once(__DIR__.'/view_bottom.php');
?>